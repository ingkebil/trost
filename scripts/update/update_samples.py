#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'plants'
"""

def format(*params):
    rs = """
    INSERT INTO `samples` (id, created)
    VALUES (%s, %s)
    ON DUPLICATE KEY UPDATE
    created=VALUES(created);
    """ % (params[0], params[1])

    rs += """
    INSERT INTO `sample_plants` (sample_id, plant_id)
    VALUES (%s, %s)
    ON DUPLICATE KEY UPDATE
    sample_id=VALUES(sample_id),
    plant_id=VALUES(plant_id);
    """ % (params[0], params[2])

    return rs

def main(argv):

    samples = ora_sql.get_all_samples_info()

    for sample in samples:
        #print ','.join(str(x) for x in [ 
        print format(
            sample['SAMPLE_ID'], # id
            sample['CREATED_ON'], # create
            sample['PLANT_ID'], # connected to what plant?
        )

if __name__ == '__main__': main(sys.argv[1:])
