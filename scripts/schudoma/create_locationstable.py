#!/usr/bin/python

import sys
import argparse

import sql
import process_xls as p_xls

DB_NAME = 'trost_prod'
TABLE_NAME = 'locations'
TABLE = [
    'id INT',
    'name VARCHAR(45)',
    'elevation FLOAT',
    'gridref_north FLOAT',
    'gridref_east FLOAT',
    'PRIMARY KEY(id)']
               
columns_d = {'limsid': (1, 'id', int),
             'name': (2, 'name', str),
             'elevation': (3, 'elevation', float),
             'gridref_north': (4, 'gridref_north', float),
             'gridref_east': (5, 'gridref_east', float)}
    
###
def main(argv):

    parser = argparse.ArgumentParser(description='Process an xls table with location information')
    parser.add_argument('-c', '--create_table', action='store_true', dest='create_table', help='If set, creates a table definition as well', default=False)
    parser.add_argument('file')
    args = parser.parse_args(argv)

    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)
    data, headers  = p_xls.read_xls_data(args.file)
    sql.write_sql_table(data, columns_d, table_name=TABLE_NAME, insert=False)   

    return None

if __name__ == '__main__': main(sys.argv[1:])
