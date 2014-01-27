#!/usr/bin/python

import sys
import argparse
from datetime import datetime

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
    'Datum': (0, 'datum', str),
    'StandortID': (1, 'location_id', int),
    'Culture': (2, 'culture_id', int),
    'treatment_id': (4, 'treatment_id', int),
    'invalid': (5, 'invalid', int),
}

extra_column_names = [ 'Kontrolle', 'Trockenstress', '50_%_nFK', '30_%_nFC' ]

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-c', '--create_table', action='store_true', default=False, dest='create_table')
    parser.add_argument('files', nargs='+')
    parser.add_argument('--pages', default=1)
    args = parser.parse_args(argv)
    
    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)
    for fn in args.files:
        for page in range(int(args.pages)): 
            data, headers  = p_xls.read_xls_data(fn, page)

            # find the right treatment columns: intersect two lists 
            treatment_column_names = [item for item in headers if item in extra_column_names]

            for column in treatment_column_names:
                data_to_keep = []
                for dobj in data:
                    if not hasattr(dobj, column): continue
                    amount = getattr(dobj, column)
                    if amount == None or amount == 0 or amount == '': continue
                    dobj.treatment_id = sql.get_value_id(column.replace('_', ' '))

                    if dobj.StandortID == 4537: # auto fill the culture information for Golm
                        cur_date = datetime.strptime(dobj.Datum, '%Y-%m-%d')
                        if cur_date.year == 2011:
                            setattr(dobj, 'Culture', 46150)
                        elif cur_date.year == 2012:
                            setattr(dobj, 'Culture', 56877)
                        elif cur_date.year == 2013:
                            setattr(dobj, 'Culture', 62328)
                        else:
                            print "Date not in range: %s" % dobj.Datum

                    data_to_keep.append(dobj)

                columns_d_extra = columns_d.copy()
                columns_d_extra[ column ] = (3, 'amount', float)
                sql.write_sql_table(data_to_keep, columns_d_extra, table_name=TABLE_NAME, add_id=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
