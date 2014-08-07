#!/usr/bin/env python

import sys
import sql
import process_xls

# the columns of all the qpcr table
qpcr_sample_pool = {
    'sample_id' : (0, 'sample_id', int),
    'aliquot_id' : (1, 'aliquot_id', int),
    'pool_id' : (2, 'pool_id', int),
}

qpcr_pool_info = {
    'pool_id' : (0, 'id', int),
    'measurement_id' : (0, 'measurement_id', int),
    '96well_plate_id' : (1, '96well_plate_id', int),
    '96well_plate_well' : (2, '96well_plate_well', int),
    '96well_plate_row' : (3, '96well_plate_row', str),
    '96well_plate_column' : (4, '96well_plate_column', int),
    '96well_plate_position' : (5, '96well_plate_position', str),
    '384well_plate_id' : (6, '384well_plate_id', int),
    '384well_plate_sector' : (7, '384well_plate_sector', int),
    '384well_plate_well' : (8, '384well_plate_well', int),
    '384well_plate_row' : (9, '384well_plate_row', str),
    '384well_plate_column' : (10, '384well_plate_column', int),
    '384well_plate_position' : (11, '384well_plate_position', str),
    'machine_nr' : (12, 'machine_nr', int),
    'measurement_date' : (13, 'measurement_date', str),
    'measurement_time' : (14, 'measurement_time', str),
}

qpcr_primer_96well_plate = {
    '96well_primer_plate_well' : (0, '96well_primer_plate_well', int),
    '96well_primer_plate_row' : (1, '96well_primer_plate_row', str),
    '96well_primer_plate_column' : (2, '96well_primer_plate_column', int),
    '96well_primer_plate_position' : (3, '96well_primer_plate_position', str),
    'primer_name' : (4, 'primer_name', lambda x: str(x) if isinstance(x, str) else str(int(x))),
}

qpcr_primer_384well_plate = {
    '384well_plate_well' : (0, '384well_primer_plate_well', int),
    '384well_plate_row' : (1, '384well_primer_plate_row', str),
    '384well_plate_column' : (2, '384well_primer_plate_column', int),
    '384well_plate_position' : (3, '384well_primer_plate_position', str),
    'primer_name' : (4, 'primer_name', lambda x: str(x) if isinstance(x, str) else str(int(x))),
}

qpcr_primer_info = {
    'primer_name' : (0, 'primer_name', str),
    'order_date' : (1, 'order_date', str),
    'fw_primer_name' : (2, 'fw_primer_name', str),
    'fw_primer_sequence' : (3, 'fw_primer_sequence', str),
    'rv_primer_name' : (4, 'rv_primer_name', str),
    'rv_primer_sequence' : (5, 'rv_primer_sequence', str),
    'dmt_id' : (6, 'dmt_id', str),
    'dmg_id' : (7, 'dmg_id', str),
    'Start_fw' : (8, 'Start_fw', lambda x: 'NULL' if x == 'NA' else x),
    'End_fw' : (9, 'End_fw', lambda x: 'NULL' if x == 'NA' else x),
    'Start_rv' : (10, 'Start_rv', lambda x: 'NULL' if x == 'NA' else x),
    'End_rv' : (11, 'End_rv', lambda x: 'NULL' if x == 'NA' else x),
    'Tm_fw' : (12, 'Tm_fw', float),
    'Tm_rv' : (13, 'Tm_rv', float),
    'GC_fw' : (14, 'GC_fw', float),
    'GC_rv' : (15, 'GC_rv', float),
    'selfcomp_fw' : (16, 'selfcomp_fw', lambda x: 'NULL' if x == 'NA' else x),
    'selfcomp_rv' : (17, 'selfcomp_rv', lambda x: 'NULL' if x == 'NA' else x),
    '3pcomp_fw' : (18, '3pcomp_fw', lambda x: 'NULL' if x == 'NA' else x),
    '3pcomp_rv' : (19, '3pcomp_rv', lambda x: 'NULL' if x == 'NA' else x),
    'prodsize' : (20, 'prodsize', int),
    'transcript_length' : (21, 'transcript_length', int),
    'selfcomp_pair' : (22, 'selfcomp_pair', lambda x: 'NULL' if x == 'NA' else x),
    '3pcomp_pair' : (23, '3pcomp_pair', lambda x: 'NULL' if x == 'NA' else x),
    'd_5ptoend' : (24, 'd_5ptoend', lambda x: 'NULL' if x == 'NA' else x),
}

qpcr_measurements = {
    '385well_plate_id' : (0, '385well_plate_id', int),
    '385well_plate_well' : (1, '385well_plate_well', int),
    '385well_plate_row' : (2, '385well_plate_row', str),
    '385well_plate_column' : (3, '385well_plate_column', int),
    '385well_plate_position' : (4, '385well_plate_position', str),
    'primer_name' : (5, 'primer_name', str),
    'ct_value' : (6, 'ct_value', float),
    'tm_value' : (7, 'tm_value', float),
}

excel_pages = [ 'qpcr_sample_pool', 'qpcr_pool_info', 'qpcr_384well_plate_sector', 'qpcr_primer_info', 'qpcr_primer_96well_plate', 'qpcr_primer_384well_plate', 'qpcr_measurements' ]
tablename_of = {
        'qpcr_sample_pool': 'qpcr_sample_aliquot_pools',
        'qpcr_pool_info': 'qpcr_pools', # TODO: None, # special case, we need to merge qpcr_384well_plate_sector with this one
        'qpcr_384well_plate_sector': None,
        'qpcr_primer_info': 'qpcr_primers',
        'qpcr_primer_96well_plate': 'qpcr_primer_96well_plates',
        'qpcr_primer_384well_plate': 'qpcr_primer_384well_plates',
        'qpcr_measurements': None
}

def main(args):
    fn = args[0] # get the filename

    # fill tables from the excel table
    for page_nr in xrange(len(excel_pages)):
        page_name = excel_pages[ page_nr ]
        table_name = tablename_of[ page_name ]

        if (table_name is not None): # skip the pages we don't need
            if table_name == 'qpcr_pools':
                data, headers = process_xls.read_xls_data(fn, page_nr, include_time=True)
                for row in data:
                    setattr(row, 'measurement_time', getattr(row, 'measurement_time')[-8:])
                    setattr(row, 'measurement_date', getattr(row, 'measurement_date')[:10])
            else:
                data, headers = process_xls.read_xls_data(fn, page_nr)

            if table_name == 'qpcr_primers':
                data = [ row for row in data if getattr(row, 'selected') == 'YES' ]

            sql.write_sql_table(data,
                globals()[page_name], # get the array with the column based on the page name
                table_name=table_name)

        # TODO:special case: calculte the positions of the 384well_plate wells to connect them to the 96well_plates
        sys.stdin.read(1)



if __name__ == '__main__': main(sys.argv[1:])

# Only one argument expected: the filename of the excel document
