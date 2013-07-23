#!/usr/bin/python

import sys
import sql
import ora_sql

DB_NAME = 'trost_prod'
TABLE_NAME = 'plants'
ALTER_TABLE = [
    'lineid INT',
    'description TEXT'
]

def main(argv):
    print sql.write_sql_alter(DB_NAME, TABLE_NAME, ALTER_TABLE)

    plant_ids = sql.get_plants()

    for aliquot in plant_ids:
        xtra = ora_sql.get_sample_description_of(aliquot)
        if xtra != None:
            print """
            UPDATE plants SET
            lineid = %d,
            description = %s
            WHERE id = %d;
            """.strip() % (xtra['SAMPLE_ID'], xtra['DESCRIPTION'], plant_ids[aliquot])

if __name__ == '__main__': main(sys.argv[1:])
