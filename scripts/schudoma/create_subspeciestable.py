#!/usr/bin/python

import sys
import argparse

import sql
import process_xls as p_xls

DEFAULT_POTATO_ID = 1

DB_NAME = 'trost_prod'
TABLE_NAME = 'subspecies'
TABLE = [
    'id INT AUTO_INCREMENT',
    'limsid INT',
    'species_id INT',
    'cultivar VARCHAR(45)',
    'breeder VARCHAR(45)',
    'reifegruppe VARCHAR(10)',
    'reifegrclass INT',
    'krautfl INT',
    'verwendung VARCHAR(10)',
    'PRIMARY KEY(id)']
               
columns_d = {'LIMS_Subspecies_id': (0, 'limsid', int),      
             'species': (1, 'species_id', int),
             'SORTE': (2, 'cultivar', str),
             'ZUECHTER': (3, 'breeder', str),
             'REIFEGRP': (4, 'reifegruppe', str),
             'Reifegrclass': (5, 'reifegrclass', int),
             'KRAUTFL': (6, 'krautfl', int),
             'Verwendung': (7, 'verwendung', str)}

def annotate_locations(data):
    locations = sql.get_locations()
    for dobj in data:
        dobj.Standort = locations[dobj.Standort]
    return data
    


###
def main(argv):

    parser = argparse.ArgumentParser(description='Process an xls table with the subspecies information')
    parser.add_argument('-c', '--ceate_table', action='store_true', dest='create_table', help='If set, creates a table definition as well', default=False)
    parser.add_argument('file')
    args = parser.parse_args(argv)

    if args.create_table:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)

    data, headers  = p_xls.read_xls_data(args.file)
    for dobj in data:
        dobj.species = DEFAULT_POTATO_ID
    sql.write_sql_table(data, columns_d, table_name=TABLE_NAME, insert=False)   

    pass


if __name__ == '__main__': main(sys.argv[1:])
