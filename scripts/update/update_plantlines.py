#!/usr/bin/python

import sys
import ora_sql
import re

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def format(aliquot):

    # add the aliquot information
    rs = """
    INSERT INTO `plantlines` (id, name, description, line_alias)
    VALUES (%s, %s, %s, %s)
    ON DUPLICATE KEY UPDATE
    name=VALUES(name),
    description=VALUES(description),
    line_alias=VALUES(line_alias);
    """ % (
        aliquot['SAMPLE_ID'],
        aliquot['NAME'],
        aliquot['DESCRIPTION'],
        aliquot['LINE_ALIAS']
    )

    return rs

def get_line_alias(alias_re, linename):
    re_hits = alias_re.search(linename)

    try:
        return repr(re_hits.group('c1') + re_hits.group('c2') + re_hits.group('lid'))
    except:
        return 'NULL' 

def main(argv):

    projects = [ 'TROST', 'TROST2' ]

    for project in projects:
        plantlines = ora_sql.get_all_plantlines(project)
        alias_re = re.compile('St\.(?P<c1>E|A).+St\.(?P<c2>A|R).+\}\.(?P<lid>[0-9]{1,3})\.|/')

        #print "INSERT INTO `programs` (id, name) VALUES (5, 'Imported from LIMS') ON DUPLICATE KEY IGNORE;"
        for line in plantlines:
            line['LINE_ALIAS'] = get_line_alias(alias_re, line['NAME']);
            print format(line)

if __name__ == '__main__': main(sys.argv[1:])
