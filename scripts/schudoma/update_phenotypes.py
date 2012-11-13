#!/usr/bin/env python

import sys
import argparse
import re
from os.path import basename, isdir

import sql
import ora_sql

"""
some constants
"""
SPECIES_ID = 1
DUMMY_CULTURE_ID    = 1
DUMMY_SUBSPECIES_ID = 1
DUMMY_PLANT_ID      = 1
DUMMY_ENTITY_ID     = -12345
DUMMY_VALUE_ID      = -12345


def get_program_id(line, program_key = 2):
    programs = {
        'fast score': 1,
        'phenotype' : 2,
        'bbch'      : 3,
    }

    try:
        return programs[ line[ program_key ].lower() ]
    except KeyError:
        return False

def get_sample_plant_keys(program_id):
    keys = {
        1: { 'entity_id_key' : 3, 'value_id_key' : 4  },
        2: { 'entity_id_key' : 8, 'value_id_key' : 10 },
    }

    try:
        return keys[ program_id ]
    except KeyError:
        return False

def is_sample_plant(line):
    keys = get_sample_plant_keys(get_program_id(line))
    if keys:
        #return line[ 3 ] == 808 and line[ 4 ] == 178
        return line[ keys['entity_id_key'] ] == 808 and line[ keys['value_id_key'] ] == 178
    return False

def is_freshweight_between(line, fr_min = 30.0, fr_max = 100.0):
    return 'freshweight' in line[5] and \
        line[6] == 'mg' and \
        fr_min <= float(line[8]) <= fr_max

def homogenize_date(date):
    (year, month, day) = [ int(x) for x in re.split(r'[^0-9]', date) ]

    if day > 999: # switch day and year if they seem to be reversed
        day,year = year,day
    elif (year < 2010):
        # it seems dates are sometimes given as '06-03-11' which is TOTALLY AMbIGUOUS!
        # anyway, check if all dates are above 2011
        day,year = year,day

    if year == 11:
        year = 2011

    return "%d-%02d-%02d" % (year, month, day)

def preprocess_line(line):
    program_id = get_program_id(line)

    if not program_id:
        return line

    # program_id: (positions in the scanner files that are ints)
    ints = {
        1: (3, 4, 7),     # entity_id, value_id, sample_id, number
        2: (3, 4, 8, 10), # sample_id, bbch_id, entity_id, value_id, number
        3: (3, 4)
    }

    for i in ints[ program_id ]:
        line[ i ] = int(line[i])

    # get the date right
    date_pos = 6 # for program_id = 2 | 3
    if program_id == 1: date_pos = 9
    line[date_pos] = homogenize_date(line[date_pos])

    return line

def save_sample_plant(sample_id, plant_id, date):
    if add_plant(plant_id): progress('Plant %d added' % plant_id)

    if not sql.exists('samples', sample_id):
        sample = {
            'id': sample_id,
            'created': date,
        }
        if sql.insert('samples', sample):
            progress('Sample %d added' % sample['id'])
            sample_plants = {
                'sample_id': sample_id,
                'plant_id': plant_id
            }
            if sql.insert('sample_plants', sample_plants):
                progress('Sample_plants (%d, %d) added' % (sample_id, plant_id))
    else:
        # check if there is already a link between sample and plant
        samples = sql.fetch_all('sample_plants', { 'sample_id': sample_id, 'plant_id': plant_id })
        if samples:
            for sample in samples:
                if sample['plant_id'] == 1:
                    if sql.update('sample_plants', { 'sample_id': sample_id }, { 'plant_id': plant_id }):
                        progress('Updated %d sample plant_id from %d to %d' % (sql.lastrowid(), 1, plant_id))
        else:
            sample_plants = {
                'sample_id': sample_id,
                'plant_id': plant_id
            }
            if sql.insert('sample_plants', sample_plants):
                progress('Sample_plants (%d, %d) added' % (sample_id, plant_id))

def add_plant(plant_id):
    if not sql.exists('plants', plant_id):
        ora_sql.set_formatting(False)
        plant = ora_sql.get_plant_information(plant_id)
        ora_sql.set_formatting(True)

        if plant == None: # fcuk! not found in LIMS, add a dummy :/
            plant = { 'id': plant_id, 'culture_id': DUMMY_CULTURE_ID, 'subspecies_id': DUMMY_SUBSPECIES_ID } # culture_id 1 is the dummy culture
        else:
            # prepare the plant
            plant = dict( (k.lower(), v) for k,v in plant.iteritems() )
            plant['subspecies_id'] = plant['u_subspecies_id']
            plant['lineid'] = plant['line_id']
            plant['id'] = plant['aliquot_id']
            plant['culture_id'] = plant['u_culture']
            del(plant['u_subspecies_id'])
            del(plant['line_id'])
            del(plant['aliquot_id'])
            del(plant['u_culture'])
            
            del(plant['location_id'])

        # add the culture if not exists
        if plant != None:
            if not sql.exists('cultures', plant['culture_id']):
                ora_sql.set_formatting(False)
                culture = ora_sql.get_culture_information(plant['culture_id'])
                ora_sql.set_formatting(True)
                if culture: # prepare the culture
                    culture = dict( (k.lower(), v) for k,v in culture.iteritems() )
                    culture['experiment_id'] = 1
                    culture['id'] = culture['study_id']
                    del(culture['study_id'])
                else: # prepare dummy
                    culture = { 'id': DUMMY_CULTURE_ID, 'name': 'placeholder' }
                if sql.insert('cultures', culture): progress('Culture %d added' % culture['id'])

            # add the subspecies if not exists
            if plant['subspecies_id'] == None:
                plant['subspecies_id'] = DUMMY_SUBSPECIES_ID
            if not sql.exists('subspecies', plant['subspecies_id']):
                print plant
                subspecies = { 'species_id': SPECIES_ID, 'id': plant['subspecies_id'] }
                if sql.insert('subspecies', subspecies): progress('Subspecies %d added' % subspecies['id'])

        return sql.insert('plants', plant)
    # TODO: check if the plant is connected to a DUMMY culture and look it up again?

def progress(s):
    #sys.stdout.write('\r%s' % s)
    #sys.stdout.write('%s' % s)
    #sys.stdout.flush()
    pass

def format_line(line):
    program_id = get_program_id(line)

    default = {
        'version': line[0],
        'object' : line[1],
        'program_id': program_id,
        'entity_id': DUMMY_ENTITY_ID,
        'value_id': DUMMY_VALUE_ID,
        'number' : None
    }

    if program_id == 1:
        return dict( default.items() + {
            'entity_id': line[3],
            'value_id': line[4],
            'attribute': line[5],
            'value': line[6],
            'sample_id': line[7],
            'number': line[8],
            'date': line[9],
            'time': line[10]
        }.items())
    
    if program_id == 2:
        return dict(default.items() + {
            'sample_id': line[3],
            'bbch_id': line[4],
            'bbch': line[5],
            'date': line[6],
            'time': line[7],
            'entity_id': line[8],
            'entity': line[9],
            'value_id': line[10],
            'attribute': line[11],
            'value': line[12],
            'number': line[13]
        }.items() )

    if program_id == 3:
        return dict(default.items() + {
            'sample_id': line[3],
            'bbch_id': line[4],
            'bbch': line[5],
            'date': line[6],
            'time': line[7]
        }.items() )

    return None

def write_lims_lines(lines, fn, max_lines=1000):
    # print '>>>', fn, 
    fnout = fn.rstrip('.txt').rstrip('.TXT')
    p = 0
    f_index = 1
    while p < len(lines):
        new_fn = '%s.%02i.lims.txt' % (fnout, f_index)
        fo = open(new_fn, 'w')
        for line in lines[p:p+max_lines]:
            fo.write('%s\n' % line)
        fo.close()
        p += max_lines
        f_index += 1
        print 'written %s' % new_fn

def main(argv):
    argparser = argparse.ArgumentParser(description='')
    argparser.add_argument('files', nargs='+')
    args = argparser.parse_args(argv)

    for fn in args.files:
        if isdir(fn): continue

        # read in file
        print 'opening %s' % fn
        f = open(fn, 'r')

        lines_raw = f.readlines()
        raw_id = None
        if sql.insert('raws', { 'data': ''.join(lines_raw), 'filename': basename(fn) }):
            raw_id = sql.lastrowid()
            progress("Added %d to raws" % raw_id)

        # preprocess
        lines = []
        try:
            line_nr = 0
            for line in lines_raw:
                line_nr += 1
                line = line.rstrip('\r\n')
                line = re.split(r'\t|;', line)
                line = preprocess_line(line)
                lines.append(line)
        except:
            print "%d: %s" % (line_nr, line)
            raise

        # add a dummy plant/culture/subspecies, just in case samples can't be connected just yet.
        if not sql.exists('cultures', 1): sql.insert('cultures', {'id': DUMMY_CULTURE_ID, 'name': 'placeholder' })
        if not sql.exists('plants'  , 1): sql.insert('plants'  , {'id': DUMMY_PLANT_ID, 'name': 'placeholder', 'culture_id': DUMMY_CULTURE_ID })
        if not sql.exists('subspecies'  , 1): sql.insert('subspecies'  , {'id': DUMMY_SUBSPECIES_ID, 'species_id': SPECIES_ID })

        # some lines need to be sent back to LIMS, this is where we store them
        lims_lines = []

        # save!
        line_nr = 0
        try:
            for line in lines:
                line_nr += 1
                program_id = get_program_id(line)
                if is_sample_plant(line):
                    line[8] = int(line[8]) # plant_id is still str
                    date = '%s %s' % (line[9], line[10])
                    #q = """ select sample_user.u_subspecies_id, a.aliquot_id, a.name, aliquot_user.u_culture, a.description, a.location_id, a.sample_id as line_id from %s join aliquot_user on a.aliquot_id = aliquot_user.aliquot_id join study_user on study_user.study_id = aliquot_user.u_culture left join sample_user on sample_user.sample_id = a.sample_id where study_user.u_project = 'TROST' AND %s = :id """
                    #if not ora_sql.exists('aliquot a', line[8], 'a.aliquot_id', q):
                    #    progress(line[8])
                    save_sample_plant(sample_id=line[7], plant_id=line[8], date=date)

                    lims_lines.append("\t".join([ str(item) for item in line ]))
                elif program_id == 1 and is_freshweight_between(line):
                    lims_lines.append("\t".join([ str(item) for item in line ]))
                else:
                    phenotype = format_line(line) # create a readable program

                    # add the actual phenotype
                    phenotype_id = None
                    if sql.insert('phenotypes', {
                        'version': phenotype['version'],
                        'object' : phenotype['object'],
                        'program_id': phenotype['program_id'],
                        'date': phenotype['date'],
                        'time': phenotype['time'],
                        'entity_id': phenotype['entity_id'],
                        'value_id': phenotype['value_id'],
                        'number': phenotype['number']
                    }):
                        phenotype_id = sql.lastrowid()
                        progress('Added %d to phenotype' % phenotype_id)

                    # depending on the object type, add it to the correct table
                    if phenotype['object'] == 'LIMS-Aliquot':
                        if add_plant(phenotype['sample_id']): print 'Plant %d added' % phenotype['sample_id']
                        sql.insert('phenotype_plants', { 'phenotype_id': phenotype_id, 'plant_id': phenotype['sample_id'] })
                    elif phenotype['object'] == 'LIMS-Sample':
                        if not sql.exists('samples', phenotype['sample_id']):
                            sample = {
                                'id': phenotype['sample_id'],
                                'created': phenotype['date'],
                            }
                            if sql.insert('samples', sample): print 'Sample %d added' % sample['id']
                        sql.insert('phenotype_samples', { 'phenotype_id': phenotype_id, 'sample_id': phenotype['sample_id'] })

                    sql.insert('phenotype_raws'   , { 'phenotype_id': phenotype_id, 'raw_id': raw_id, 'line_nr': line_nr })
                    if program_id > 1:
                        sql.insert('phenotype_bbches', { 'phenotype_id': phenotype_id, 'bbch_id': phenotype['bbch_id']})
        except:
            progress("%d: %s" % (line_nr, line))
            raise
        
        # save the current saved lines for LIMS
        write_lims_lines(lims_lines, fn)

    sql.commit()

if __name__ == '__main__':  main(sys.argv[1:])
