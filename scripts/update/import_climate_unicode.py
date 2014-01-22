#!/usr/bin/python
# -*- coding: utf8 -*-

import sys
import argparse

import sql
import process_xls as p_xls

DB_NAME = 'trost_prod'
TABLE_NAME = 'temperatures'

# column name in xls: (order, column name in sql, cast function[, lookup function])
columns_d = {
    'Datum': (0, 'datum', str),
    'StandortID': (1, 'location_id', int),
    'Tmin (°C)': (2, 'tmin', float),
    'Tmax (°C)': (3, 'tmax', float),
    'invalid': (5, 'invalid', str),
}

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('files', nargs='+')
    parser.add_argument('--pages', default=1)
    parser.add_argument('--standortid', type=int)
    args = parser.parse_args(argv)

    for fn in args.files:
        for page in range(int(args.pages)): 
            data, headers  = p_xls.read_xls_data(fn, page)

            data_to_keep = []
            for d in data:
                tmin = getattr(d, 'Tmin_(°C)')
                tmax = getattr(d, 'Tmax_(°C)')
                if tmin != None and tmin != '' and tmax != None and tmax != '':
                    data_to_keep.append(d)
                if args.standortid != None:
                    setattr(d, 'StandortID', args.standortid)

            sql.write_sql_table(data_to_keep, columns_d, table_name=TABLE_NAME, add_id=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
