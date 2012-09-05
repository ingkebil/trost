#!/usr/bin/env python

import sys
import argparse
import re

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
        return line[ 3 ] == 808 and line[ 4 ] == 178
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

    return line

def save_sample_plant(sample_id, plant_id, date):
    if not sql.exists('plants', plant_id):
        plant = ora_sql.get_plant_information(plant_id)

        if plant == None: # fcuk! not found in LIMS, add a dummy :/
            plant = { 'id': plant_id, 'culture_id': 1, 'subspecies_id': 1 } # culture_id 1 is the dummy culture
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

        # add the culture if not exists
        if plant != None:
            if not sql.exists('cultures', plant['culture_id']):
                ora_sql.set_formatting(False)
                culture = ora_sql.get_culture_information(plant['culture_id'])
                ora_sql.set_formatting(True)
                if culture:
                    # prepare the culture
                    culture = dict( (k.lower(), v) for k,v in culture.iteritems() )
                    culture['experiment_id'] = 1
                    culture['id'] = culture['study_id']
                    del(culture['study_id'])
                else: # prepare dummy
                    culture = { 'id'  : 1, 'name': 'placeholder' }
                if sql.insert('cultures', culture): print 'Culture %d added' % culture['id']

            if not sql.exists('subspecies', plant['subspecies_id']):
                subspecies = { 'species_id': SPECIES_ID, 'id': plant['subspecies_id'] }
                if sql.insert('subspecies', subspecies): print 'Subspecies %d added' % subspecies['id']

        if sql.insert('plants', plant): print 'Plant %d added' % plant_id

    if not sql.exists('samples', sample_id):
        sample = {
            'id': sample_id,
            'created': date,
            'plant_id': plant_id
        }
        if sql.insert('samples', sample): print 'Sample %d added' % sample['id']

def main(argv):
    argparser = argparse.ArgumentParser(description='')
    argparser.add_argument('files', nargs='+')
    args = argparser.parse_args(argv)

    for fn in args.files:
        # read in file
        f = open(fn, 'r')
        print 'opening %s' % fn
        lines = []
        for line in f.readlines():
            line = line.rstrip('\r\n')
            line = re.split(r'\t|;', line)
            line = preprocess_line(line)
            lines.append(line)

        for line in lines:
            if is_sample_plant(line):
                line[8] = int(line[8]) # plant_id is still str
                date = '%s %s' % (homogenize_date(line[9]), line[10])
                #q = """ select sample_user.u_subspecies_id, a.aliquot_id, a.name, aliquot_user.u_culture, a.description, a.location_id, a.sample_id as line_id from %s join aliquot_user on a.aliquot_id = aliquot_user.aliquot_id join study_user on study_user.study_id = aliquot_user.u_culture left join sample_user on sample_user.sample_id = a.sample_id where study_user.u_project = 'TROST' AND %s = :id """
                #if not ora_sql.exists('aliquot a', line[8], 'a.aliquot_id', q):
                #    print line[8]
                save_sample_plant(sample_id=line[7], plant_id=line[8], date=date)
            

    sql.commit()






    pass

if __name__ == '__main__':  main(sys.argv[1:])
