#!/usr/bin/env python

import sys
import sql


LOG_TABLE_NAME = '__log'

insert = """
drop trigger if exists %(table)s_insert_trigger;
"""

delete = """
drop trigger if exists %(table)s_delete_trigger;
"""

update = """
drop trigger if exists %(table)s_update_trigger;
"""

def main(argv):
    # make sure not to add triggers to the logging table
    blacklist = [ LOG_TABLE_NAME, '__logmessages' ]

    # get all tables from the DB that contain an 'id' column, as we are going to monitor that.
    tables = sql.get_tables_with_column('id')

    # add two triggers to each table
    for table in tables:
        if table in blacklist: continue
        print insert % { 'table': table }
        print delete % { 'table': table }

    # get all tables with 'invalid' column name and add an update trigger to those
    invalid_tables = sql.get_tables_with_column('invalid')
    for table in invalid_tables:
        if table in blacklist: continue
        print update % { 'table': table }

    

if __name__ == '__main__':
    main(sys.argv[1:])
