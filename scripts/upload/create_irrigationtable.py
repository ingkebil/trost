#!/usr/bin/python

import sys
import argparse

import sql
import process_xls as p_xls

DEFAULT_EXPERIMENT_ID = 1

""" Change to whatever is needed. """
DEFAULT_DATE_STR = ''

DB_NAME = 'trost_prod'
TABLE_NAME = 'irrigation'
TABLE = [
    'id INT AUTO_INCREMENT',
    '`date` DATE',
    'treatment_id INT',
    'location_id INT',
    '`value` FLOAT',
    'PRIMARY KEY(id)'
    ]


# need 4 times these columns as we are going to parse the same file 4 times: for each possible type of treatment.
# column name in xls: (order, column name in sql, cast function[, lookup function])
columns_d = {
    'Datum': (0, 'date', str),
    'treatment_id': (1, 'treatment_id', int),
    'StandortID': (2, 'location_id', int),
}

extra_column_names = [ 'Kontrolle', 'Trockenstress', '50_%_nFK', '30_%_nFK' ]

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-c', '--create_table', action='store_true', default=False, dest='create_table')
    parser.add_argument('files', nargs='+')
    args = parser.parse_args(argv)
    
    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)
    for fn in args.files:
        data, headers  = p_xls.read_xls_data(fn)

        # find the right treatment columns: intersect two lists 
        treatment_column_names = [item for item in headers if item in extra_column_names]

        for column in treatment_column_names:
            for dobj in data:
                dobj.treatment_id = sql.get_value_id(column.replace('_', ' '))
            columns_d_extra = columns_d.copy()
            columns_d_extra[ column ] = (3, 'value', float)
            sql.write_sql_table(data, columns_d_extra, table_name=TABLE_NAME, add_id=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
