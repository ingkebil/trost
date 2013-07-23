#!/usr/bin/python

# TODO this should seriously be replaced by a script that pulls this information from LIMS instead of an outdated xls file

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
    return """
        INSERT INTO `plants` (id, name, culture_id, subspecies_id, created, lineid, description)
        VALUES (%s,%s,%s,%s,%s,%s,%s)
        ON DUPLICATE KEY UPDATE
        name=VALUES(name),
        culture_id=VALUES(culture_id),
        subspecies_id=VALUES(subspecies_id),
        created=VALUES(created),
        lineid=VALUES(lineid),
        description=VALUES(description);
        """ % (params)

def main(argv):

    plants = ora_sql.get_all_plants_info() + ora_sql.get_all_dead_plants_info()

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
