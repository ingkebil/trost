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

extra_column_names = [ 'Kontrolle', 'Trockenstress' ]

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-c', '--create_table', action='store_true', default=False, dest='create_table')
    parser.add_argument('files', nargs='+')
    args = parser.parse_args(argv)
    
    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)

    # create some dates
    d2011_04_21 = datetime.strptime('2011 04 21', '%Y %m %d')
    d2011_09_01 = datetime.strptime('2011 09 01', '%Y %m %d')
    d2012_04_17 = datetime.strptime('2012 04 17', '%Y %m %d')
    d2012_08_28 = datetime.strptime('2012 08 28', '%Y %m %d')
    d2013_04_22 = datetime.strptime('2013 04 22', '%Y %m %d')
    d2013_08_20 = datetime.strptime('2013 08 20', '%Y %m %d')

    for fn in args.files:
        data, headers  = p_xls.read_xls_data(fn)

        # find the right treatment columns: intersect two lists 
        treatment_column_names = [item for item in headers if item in extra_column_names]

        for column in treatment_column_names:
            data_to_keep = []
            for dobj in data:
                # make sure we have the treatment column with a value
                if not hasattr(dobj, column): continue
                amount = getattr(dobj, column)
                if amount == None or amount == 0: continue
                try:
                    amount = float(amount)
                except ValueError:
                    continue

                # get the treatment id
                dobj.treatment_id = sql.get_value_id(column.replace('_', ' '))

                # * we need to recalculate the amount based on some rules
                # * add default culture according to year
                cur_date = datetime.strptime(dobj.Datum, '%Y-%m-%d')
                if d2011_04_21 <= cur_date <= d2011_09_01:
                    setattr(dobj, column, float(amount) * 0.7 * 4.4)
                    setattr(dobj, 'Culture', 44443)
                elif d2012_04_17 <= cur_date <= d2012_08_28:
                    setattr(dobj, column, float(amount) * 0.55 * 4.4)
                    setattr(dobj, 'Culture', 56726)
                elif d2013_04_22 <= cur_date <= d2013_08_20:
                    setattr(dobj, column, float(amount) * 0.7 * 4.4)
                    setattr(dobj, 'Culture', 62326)
                else:
                    print "Date not in range: %s" % dobj.Datum



                data_to_keep.append(dobj)
            columns_d_extra = columns_d.copy()
            columns_d_extra[ column ] = (3, 'amount', float)
            sql.write_sql_table(data_to_keep, columns_d_extra, table_name=TABLE_NAME, add_id=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
