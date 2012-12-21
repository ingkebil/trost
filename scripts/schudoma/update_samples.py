#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'plants'
"""

def format(*params):
    return "REPLACE into `samples` VALUES (%s, %s); REPLACE into `sample_plants` VALUES (NULL, %s, %s);" % (
            params[0],
            params[1],
            params[0],
            params[2]
    )


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
