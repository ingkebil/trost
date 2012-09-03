#!/usr/bin/python

import sys
import argparse

import process_xls as p_xls
import sql

DB_NAME = 'trost_prod'
TREATMENT_TABLE_NAME = 'treatments'
TREATMENT_TABLE = [
    'id INT AUTO_INCREMENT',
    'name VARCHAR(45)',
    'aliquotid INT NOT NULL',
    'alias VARCHAR(45) NULL',
    'treatment VARCHAR(45) NULL',
    'PRIMARY KEY(id)']

columns_d = {'Name': (0, 'name', str), 
             'Aliquot_Id': (1, 'aliquot_id', int), 
             'Alias': (2, 'alias', str),
             'Treatment': (3, 'treatment', str)
             }
    
###
def main(argv):

    parser = argparse.ArgumentParser()
    parser.add_argument('-c', '--create_table', action='store_true', default=False, dest='create_table')
    parser.add_argument('file')
    args = parser.parse_args(argv)

    if args.create_table:
        sql.write_sql_header(DB_NAME, TREATMENT_TABLE_NAME, TREATMENT_TABLE)

    sheet_index=p_xls.DEFAULT_TREATMENT_ALIQUOT_INDEX

    data, headers  = p_xls.read_xls_data(args.file, sheet_index=sheet_index) 
    sql.write_sql_table(data, columns_d, table_name=TREATMENT_TABLE_NAME, add_id=True, insert=True)
    return None

if __name__ == '__main__': main(sys.argv[1:])
