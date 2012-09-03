#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'plants'
"""

culture_id_of = {}

def format(*params):
    global culture_id_of # because some plants don't have a culture_id filled in we presume that the same subspecies_id will have come from the same culture. So we build up a dict() just in case ..
    if params[2] != 'NULL':
        culture_id_of[ params[3] ] = params[2]
    else:
        params = list(params)
        params[2] = culture_id_of[ params[3] ]
        params = tuple(params)
    return "REPLACE into `plants` VALUES (%s, %s, %s, %s, %s, %s, %s);" % (params)

def main(argv):

    plants = ora_sql.get_all_plants_info()

    for plant in plants:
        #print ','.join(str(x) for x in [ 
        print format(
            plant['PLANT_ID'],
            plant['NAME'],
            plant['CULTURE_ID'],
            plant['U_SUBSPECIES_ID'],
            'NULL',
            plant['LINE_ID'],
            plant['DESCRIPTION']
        )

if __name__ == '__main__': main(sys.argv[1:])
