#!/usr/bin/python

import sys
import argparse

import sql
import process_xls as p_xls
import data_objects as DO

DEFAULT_EXPERIMENT_ID = 1

""" Change to whatever is needed. """
DEFAULT_DATE_STR = ''

DB_NAME = 'trost_prod'
TABLE_NAME = 'cultures'
TABLE = [
    'id INT AUTO_INCREMENT',
    'name VARCHAR(45)', 
    '`condition` VARCHAR(45)',
    'created DATETIME',
    'description TEXT',
    'experiment_id INT',
    'plantspparcelle INT',
    'location_id INT',
    'planted DATE',
    '`terminated` DATE',
    'PRIMARY KEY(id)']

columns_d = {
    'Study_Id': (0, 'id', int),
    'Name': (1, 'name', str),
    'condition': (2, 'condition', str),
    'created': (3, 'created', str),    
    'Description': (4, 'description', str),
    'experiment_id': (5, 'experiment_id', int),
    'Itempobject': (6, 'plantspparcelle', int),
    'limslocation': (7, 'location_id', int),
    'planted': (8, 'planted', str),
    'terminated': (9, 'terminated', str)}

###
def main(argv):

    parser = argparse.ArgumentParser(description='Process an xls table with culture information')
    parser.add_argument('-c', '--create_table', action='store_true', dest='create_table', help='If set, creates a table definition as well', default=False)
    parser.add_argument('-d', '--database-import', action='store_true', dest='database', help='If set, replaces from LIMS instead of xls', default=False)
    parser.add_argument('file')
    args = parser.parse_args(argv)
    
    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)

    if args.database:
        import ora_sql
        #data = [ dict((k.lower(), v) for k,v in d.iteritems()) for d in ora_sql.get_all_cultures() ]
        data = []
        header = []
        ora_sql.set_formatting(False)
        all_cultures = ora_sql.get_all_cultures()
        # create the header
        if len(all_cultures) > 0:
            for k in all_cultures[0].keys():
                header.append(k.lower())
        # prepare the data
        for row in all_cultures:
            data.append(DO.DataObject(header, row.values()))
        ora_sql.set_formatting(True)

        global columns_d
        columns_d = dict((k.lower(), v) for k,v in columns_d.iteritems()) # need to lowercase the columns_d keys because Oracle ignore's my nice naming scheme for the data-keys. Making them fail to match up.
    else:
        data, headers  = p_xls.read_xls_data(args.file)
        # return None
    for dobj in data:
        dobj.experiment_id = DEFAULT_EXPERIMENT_ID
        dobj.condition = ''
        dobj.created = DEFAULT_DATE_STR
    sql.write_sql_table(data, columns_d, table_name=TABLE_NAME, insert=False)   

    return None

if __name__ == '__main__': main(sys.argv[1:])
