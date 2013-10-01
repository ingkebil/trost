#!/usr/bin/env python

import sys
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
    # get all files
    files = sql.fetch_all(None, None, "SELECT * FROM `raws`")

    for f in files:
        print("Processing %s" % f['filename'])
        raw_id = f['id']

        # preprocess
        lines = []
        try:
            line_nr = 0
            for line in f['data'].split("\r\n"):
                if len(line) == 0: continue
                line_nr += 1
                line = line.rstrip('\r\n')
                line = re.split(r'\t|;', line)
                line = preprocess_line(line)
                lines.append(line)
        except:
            print "%d: %s" % (line_nr, line)
            raise

        # fix!
        line_nr = 0
        try:
            for line in lines:
                line_nr += 1
                phenotype = format_line(line) # create a readable program

                # look up the phenotype id based on the line number
                try:
                    if (phenotype['entity_id'] == 808 and phenotype['value_id'] == 178): continue
                    phenotype_id = sql.fetch_all('phenotype_raws', { 'line_nr': line_nr, 'raw_id': raw_id })[0]['phenotype_id']
                except:
                    print "%d: %d" % (line_nr, raw_id)
                    raise

                # get the phenotype_%s % (plant, sample, aliquot) id, if any
                ph_plant = sql.fetch('phenotype_plants', phenotype_id, 'phenotype_id')
                ph_sample = sql.fetch('phenotype_samples', phenotype_id, 'phenotype_id')
                ph_aliquot = sql.fetch('phenotype_aliquots', phenotype_id, 'phenotype_id')

                # check where the link should belong and remove the others, if any
                if ora_sql.is_plant(phenotype['sample_id']) or ora_sql.was_plant(phenotype['sample_id']):
                    if ph_sample != False: print "DELETE FROM `phenotype_samples` WHERE id = %s;" % ph_sample['id']
                    if ph_aliquot != False: print "DELETE FROM `phenotype_aliquots` WHERE id = %s;" % ph_aliquot['id']
                elif ora_sql.is_sample(phenotype['sample_id']):
                    if ph_aliquot != False: print "DELETE FROM `phenotype_aliquots` WHERE id = %s;" % ph_aliquot['id']
                    if ph_plant != False: print "DELETE FROM `phenotype_plants` WHERE id = %s;" % ph_plant['id']
                elif ora_sql.is_aliquot(phenotype['sample_id']):
                    if ph_sample != False: print "DELETE FROM `phenotype_samples` WHERE id = %s;" % ph_sample['id']
                    if ph_plant != False: print "DELETE FROM `phenotype_plants` WHERE id = %s;" % ph_plant['id']
                else:
                    print "%s NOT found!!" % phenotype['sample_id']

        except:
            progress("%d: %s" % (line_nr, line))
            raise

    #sql.commit()

if __name__ == '__main__':  main(sys.argv[1:])
