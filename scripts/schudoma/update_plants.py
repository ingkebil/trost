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
#    return params[0:2]

def main(argv):

    plants = ora_sql.get_all_plants_info() + ora_sql.get_all_dead_plants_info()
    #plants = ora_sql.get_all_dead_plants_info()

    for plant in plants:
        #print ','.join(str(x) for x in [ 
        print format(
            plant['ALIQUOT_ID'], # id
            plant['ALIQUOT'],    # name
            plant['CULTURE'],    # culture_id
            plant['SUBSPECIES_ID'], # subspecies_id
            plant['CREATED_ON'], # created
            plant['LINE'],       # lineid
            'NULL'
        )

    # make sure some Desiree plants are added with the right subspecies
    print "update plants set subspecies_id = 382 where subspecies_id is NULL and name like '%St.D.%';"

if __name__ == '__main__': main(sys.argv[1:])
