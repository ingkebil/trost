#!/usr/bin/env python

import sys

# the columns of all the qpcr table
c_sample_aliquot_pool = {
    'sample_id' : (0, 'sample_id', int),
    'aliquot_id' : (1, 'aliquot_id', int),
    'pool_id' : (2, 'pool_id', int),
}

c_pools = {
    'id' : (0, 'id', int),
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

c_primer_96well_plates = {
    '96well_primer_plate_well' : (0, '96well_primer_plate_well', int),
    '96well_primer_plate_row' : (1, '96well_primer_plate_row', str),
    '96well_primer_plate_column' : (2, '96well_primer_plate_column', int),
    '96well_primer_plate_position' : (3, '96well_primer_plate_position', str),
    'primer_name' : (4, 'primer_name', int),
}

c_primer_384well_plates = {
    '384well_primer_plate_well' : (0, '384well_primer_plate_well', int),
    '384well_primer_plate_row' : (1, '384well_primer_plate_row', str),
    '384well_primer_plate_column' : (2, '384well_primer_plate_column', int),
    '384well_primer_plate_position' : (3, '384well_primer_plate_position', str),
    'primer_name' : (4, 'primer_name', str),
}

c_primers = {
    'primer_name' : (0, 'primer_name', str),
    'order_date' : (1, 'order_date', str),
    'fw_primer_name' : (2, 'fw_primer_name', str),
    'fw_primer_sequence' : (3, 'fw_primer_sequence', str),
    'rv_primer_name' : (4, 'rv_primer_name', str),
    'rv_primer_sequence' : (5, 'rv_primer_sequence', str),
    'dmt_id' : (6, 'dmt_id', str),
    'dmg_id' : (7, 'dmg_id', str),
    'Start_fw' : (8, 'Start_fw', int),
    'End_fw' : (9, 'End_fw', int),
    'Start_rv' : (10, 'Start_rv', int),
    'End_rv' : (11, 'End_rv', int),
    'Tm_fw' : (12, 'Tm_fw', float),
    'Tm_rv' : (13, 'Tm_rv', float),
    'GC_fw' : (14, 'GC_fw', float),
    'GC_rv' : (15, 'GC_rv', float),
    'selfcomp_fw' : (16, 'selfcomp_fw', int),
    'selfcomp_rv' : (17, 'selfcomp_rv', int),
    '3pcomp_fw' : (18, '3pcomp_fw', int),
    '3pcomp_rv' : (19, '3pcomp_rv', int),
    'prodsize' : (20, 'prodsize', int),
    'transcript_length' : (21, 'transcript_length', int),
    'selfcomp_pair' : (22, 'selfcomp_pair', int),
    '3pcomp_pair' : (23, '3pcomp_pair', int),
    'd_5ptoend' : (24, 'd_5ptoend', int),
}

c_measurements = {
    '385well_plate_id' : (0, '385well_plate_id', int),
    '385well_plate_well' : (1, '385well_plate_well', int),
    '385well_plate_row' : (2, '385well_plate_row', str),
    '385well_plate_column' : (3, '385well_plate_column', int),
    '385well_plate_position' : (4, '385well_plate_position', str),
    'primer_name' : (5, 'primer_name', str),
    'ct_value' : (6, 'ct_value', float),
    'tm_value' : (7, 'tm_value', float),
}

exell_pages = [ 'qpcr_sample_pool', 'qpcr_pool_info', 'qpcr_384well_plate_sector', 'qpcr_primer_info', 'qpcr_primer_96well_plate', 'qpcr_primer_384well_plate', 'qpcr_measurements' ]

def main(args):
    fn = args[0] # get the filename

    # fill tables from the exell table
    for page in len(exell_pages):
        data, headers = p_xls.read_xls_data(fn, page)

    pass

if __name__ == '__main__': main(sys.args[1:])

# Only one argument expected: the filename of the exell document
