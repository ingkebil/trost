#!/usr/bin/env python

import ora_sql
import sql
import sys

def main(argv):
    ora_aliquots = ora_sql.get_all_aliquots_info()
    sql_aliquots = sql._get_table('select * from samples', 'id', 'id')
    sql_plants   = sql._get_table('select * from plants', 'id', 'id')

    ora_ali_min = 1000000000
    ora_ali_max = 0 
    mismatches = 0
    for ora_aliquot in ora_aliquots:
        # determine min/max
        if ora_aliquot['ALIQUOT'] < ora_ali_min:
            ora_ali_min = ora_aliquot['ALIQUOT']
        elif ora_aliquot['ALIQUOT'] > ora_ali_max:
            ora_ali_max = ora_aliquot['ALIQUOT']

        if not sql_plants.has_key(ora_aliquot['ALIQUOT']):
            mismatches +=1

    print "ora_ali_min: %s" % ora_ali_min
    print "ora_ali_max: %s" % ora_ali_max
    print "count      : %s" % len(ora_aliquots)
    print "mismatches : %s" % mismatches


if __name__ == '__main__': main(sys.argv[1:])
