#!/usr/bin/env python

"""
Update a phenotype file instead of uploading it
"""


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
DUMMY_ENTITY_ID     = -12346
DUMMY_VALUE_ID      = -12346


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
        raw_id = sql.fetch_all('raws', { 'filename': basename(fn) })[0]['id']
        progress("Found %d of %s" % (raw_id, fn))

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

        # save!
        line_nr = 0
        try:
            for line in lines:
                line_nr += 1
                phenotype = format_line(line) # create a readable program

                # add the actual phenotype
                phenotype_id = None
                phenotype_q_params = dict( phenotype.items() + {
                    'entity_id': -12345,
                    'filename': basename(fn)
                }.items())
                del phenotype_q_params['attribute']
                del phenotype_q_params['value']
                phenotype_q_params['pp.plant_id'] = phenotype_q_params.pop('sample_id')

                q = """
                    select phenotypes.id from phenotypes
                    join phenotype_raws pr on pr.phenotype_id = phenotypes.id
                    join raws r on r.id = pr.raw_id
                    left join phenotype_plants pp on pp.phenotype_id = phenotypes.id
                    where """
                q +=  ' and '.join([ '%s=%s' % (k, '%s') for k in phenotype_q_params.keys()])
                sql_phenotype = sql.fetch_all(None, phenotype_q_params, q)

                if len(sql_phenotype) == 1:
                    if sql.update(
                        'phenotypes',
                        { 'id': sql_phenotype[0]['id'] },
                        { 'entity_id': phenotype['entity_id'] }
                    ):
                        phenotype_id = sql.lastrowid()
                        progress('Added %d to phenotype' % phenotype_id)
        except:
            progress("%d: %s" % (line_nr, line))
            raise

    sql.commit()

if __name__ == '__main__':  main(sys.argv[1:])



"""
REMARK 13/09/30: THIS COULD BE DONE BETTER!
As we have the line nr information, we could disregard the general lookup to
match an entry from the DB with an entry from the file based on the line nr in the file.

This way, changed information in the DB or the file preventing matches would be fixed.


TODO: information that is NULL in the scanner files, should be made NULL in the DB as well!

"""
