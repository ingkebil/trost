#!/usr/bin/python

import sys
import argparse

import sql
import process_xls as p_xls

DEFAULT_EXPERIMENT_ID = 1

""" Change to whatever is needed. """
DEFAULT_DATE_STR = ''

DB_NAME = 'trost_prod'
TABLE_NAME = 'temps'

# column name in xls: (order, column name in sql, cast function[, lookup function])
columns_d = {
    'Datum': (0, 'datum', str),
    'Regen': (1, 'percipitation', float),
    'Bewaesserung': (2, 'irrigation', float),
    'Tmin': (3, 'tmin', float),
    'Tmax': (4, 'tmax', float),
    'Ort': (5, 'location_id', int),
    'invalid': (6, 'invalid', str),
}

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('files', nargs='+')
    args = parser.parse_args(argv)
    
    for fn in args.files:
        for page in range(1): 
            data, headers  = p_xls.read_xls_data(fn, page)
            sql.write_sql_table(data, columns_d, table_name=TABLE_NAME, add_id=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
