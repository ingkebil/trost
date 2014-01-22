#!/usr/bin/python
# -*- coding: utf8 -*-

import sys
import argparse

import sql
import process_xls as p_xls

DB_NAME = 'trost_prod'
TABLE_NAME = 'irrigation'

# column name in xls: (order, column name in sql, cast function[, lookup function])
# columns in irrigation table
irrigation_columns_d = {
    'Datum': (0, 'datum', str),
    'StandortID': (1, 'location_id', int),
    'culture_id': (2, 'culture_id', int),
    'Bewasserung stress': (3, 'amount', float), 
    #'Bewasserung controle': (4, 'amount', float), # don't trigger on this one, 
    'treatment_id': (4, 'treatment_id', int),
    'invalid': (5, 'invalid', str),
}

def prepare_data_rows(data, columns_d, add_id=True):
    rows = []
    columns_d_ = sql.sanitize_columns(columns_d)
    for dobj in data:
        treatment_id_of = { 'Bewasserung_stress': 170, 'Bewasserung_controle': 169 }
        for bewasserung_key, treatment_id in treatment_id_of.items():
            row = []
            nvm = False # so we can break out as soon as we do not have a value
            for key, val in columns_d_.items():
                if (key == 'Bewasserung_stress'): # special case: add treatment_id based on the bewasserung column header
                    if hasattr(dobj, bewasserung_key) and getattr(dobj, bewasserung_key) != '':
                        treatment_val = (4, 'treatment_id')
                        row.append( treatment_val + (int, treatment_id_of[ bewasserung_key ]) )
                        row.append( (3, bewasserung_key, float, getattr(dobj, bewasserung_key)) )
                    else:
                        nvm = True # nevermind this one ;)
                        break
                else:
                    if hasattr(dobj, key) and getattr(dobj, key) != '': # column found with value, get value
                        row.append(val + (getattr(dobj, key),))
                    else: # no column found, add NULL
                        row.append(val[:-1] + (str, 'NULL'))
            if add_id:
                row = [(-1, 'id', str, 'NULL')] + row # add the id

            if (not nvm):
                rows.append(sorted(row))
    return rows

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('files', nargs='+')
    parser.add_argument('--pages', default=1)
    args = parser.parse_args(argv)

    for fn in args.files:
        for page in range(int(args.pages)): 
            data, headers  = p_xls.read_xls_data(fn, page)
            rows = prepare_data_rows(data, irrigation_columns_d, add_id=True)
            sql.write_standard_sql_table(rows, table_name='irrigation', out=sys.stdout, insert=True)

    return None

if __name__ == '__main__': main(sys.argv[1:])
