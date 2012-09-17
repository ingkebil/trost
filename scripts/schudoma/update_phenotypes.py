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

        if sql.insert('plants', plant): progress('Plant %d added' % plant_id)
    # TODO: check if the plant is connected to a DUMMY culture and look it up again?

    if not sql.exists('samples', sample_id):
        sample = {
            'id': sample_id,
            'created': date,
            'plant_id': plant_id
        }
        if sql.insert('samples', sample): progress('Sample %d added' % sample['id'])
    else:
        sample = sql.fetch('samples', sample_id)
        if sample['plant_id'] == 1:
            if sql.update('samples', { 'id': sample_id }, { 'plant_id': plant_id }):
                progress('Updated %d sample plant_id from %d to %d' % (sql.lastrowid(), 1, plant_id))

def progress(s):
    #sys.stdout.write('\r%s' % s)
    sys.stdout.write('%s' % s)
    sys.stdout.flush()

def format_line(line):
    program_id = get_program_id(line)

    default = {
        'version': line[0],
        'object' : line[1],
        'program_id': program_id,
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
                    #save_sample_plant(sample_id=line[7], plant_id=line[8], date=date)
                else:
                    phenotype = format_line(line) # create a readable program

                    if not sql.exists('samples', phenotype['sample_id']):
                        sample = {
                            'id': phenotype['sample_id'],
                            'created': phenotype['date'],
                            'plant_id': DUMMY_PLANT_ID
                        }
                        if sql.insert('samples', sample): print 'Sample %d added' % sample['id']

                    phenotype_id = None
                    if sql.insert('phenotypes', {
                        'version': phenotype['version'],
                        'object' : phenotype['object'],
                        'program_id': phenotype['program_id'],
                        'date': phenotype['date'],
                        'time': phenotype['time'],
                        'sample_id': phenotype['sample_id']
                    }):
                        phenotype_id = sql.lastrowid()
                        progress('Added %d to phenotype' % phenotype_id)

                    sql.insert('phenotype_raws'  , { 'phenotype_id': phenotype_id, 'raw_id': raw_id, 'line_nr': line_nr })
                    if program_id != 3:
                        sql.insert('phenotype_entities', { 'phenotype_id': phenotype_id, 'entity_id': phenotype['entity_id'] })
                        sql.insert('phenotype_values', { 'phenotype_id': phenotype_id, 'value_id': phenotype['value_id'], 'number': phenotype['number']})
                    if program_id > 1:
                        sql.insert('phenotype_bbches', { 'phenotype_id': phenotype_id, 'bbch_id': phenotype['bbch_id']})
        except:
            progress("%d: %s" % (line_nr, line))
            raise

    sql.commit()

if __name__ == '__main__':  main(sys.argv[1:])
