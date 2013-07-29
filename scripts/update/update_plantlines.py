#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def format(aliquot):

    # add the aliquot information
    rs = """
    INSERT INTO `plantlines` (id, name, description)
    VALUES (%s, %s, %s)
    ON DUPLICATE KEY UPDATE
    name=VALUES(name),
    description=VALUES(description);
    """ % (
        aliquot['SAMPLE_ID'],
        aliquot['NAME'],
        aliquot['DESCRIPTION'],
    )

    return rs

def main(argv):

    projects = [ 'TROST', 'TROST2' ]

    for project in projects:
        plantlines = ora_sql.get_all_plantlines(project)

        #print "INSERT INTO `programs` (id, name) VALUES (5, 'Imported from LIMS') ON DUPLICATE KEY IGNORE;"
        for line in plantlines:
            print format(line)

if __name__ == '__main__': main(sys.argv[1:])
