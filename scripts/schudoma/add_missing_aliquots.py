#!/usr/bin/python

import sys
import ora_sql
import login

_odb = login.get_ora_db()

DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'

###
def main(argv):

    fn = argv[0]
    csv = False
    if len(argv) == 2:
        fn = argv[1]
        csv = True
    lines = open(fn).readlines()

    if csv:
        print "aliquot, plantid, sample_date, amount, amount_unit, organ"
        for line in lines:
            aliquot_id = line.strip()
            aliquot = ora_sql.get_ext_sample_description_of(aliquot_id)
            print ','.join([ str(x) for x in [ aliquot['ALIQUOT_ID'], aliquot['U_ALIQUOT_LINK_A'], aliquot['CREATED_ON'], aliquot['AMOUNT'], aliquot['U_I_AMOUNT'], aliquot['U_ORGAN'] ] ] )
    else:
        for line in lines:
            aliquot_id = line.strip()
            aliquot = ora_sql.get_ext_sample_description_of(aliquot_id)
            print """
            INSERT INTO aliquots (id, aliquot, plantid, sample_date, amount, amount_unit, organ)
            VALUES (NULL, %d, %s, %s, %s, %s, %s);
            """ % (aliquot['ALIQUOT_ID'], aliquot['U_ALIQUOT_LINK_A'], aliquot['CREATED_ON'], aliquot['AMOUNT'], aliquot['U_I_AMOUNT'], aliquot['U_ORGAN'])

    return None

if __name__ == '__main__': main(sys.argv[1:])
