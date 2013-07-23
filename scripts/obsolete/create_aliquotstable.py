#!/usr/bin/python

import sys
import sql
import ora_sql

DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
TABLE = [
    'id INT AUTO_INCREMENT',
    'aliquot INT', 
    'plantid INT', 
    'sample_date DATE',
    'amount INT',
    'amount_unit VARCHAR(20)',
    'organ VARCHAR(255)',
    'PRIMARY KEY(id)']

###
def main(argv):
    aliquots = ora_sql.get_aliquots_trost()

    if len(argv) > 0 and argv[0] == '-c':
        print "aliquot_id,plant_id,sample_date,amount,unit,organ"
        for aliquot in aliquots:
            print ','.join([ str(x) for x in [ aliquot['ALIQUOT_ID'], aliquot['U_ALIQUOT_LINK_A'], aliquot['CREATED_ON'], aliquot['AMOUNT'], aliquot['U_I_AMOUNT'], aliquot['U_ORGAN'] ] ] )
    else:
        sql.write_sql_header(DB_NAME, TABLE_NAME, TABLE)
        for aliquot in aliquots:
            print """
            INSERT INTO aliquots (id, aliquot, plantid, sample_date, amount, amount_unit, organ)
            VALUES (NULL, %d, %s, %s, %s, %s, %s);
            """.strip() % (aliquot['ALIQUOT_ID'], aliquot['U_ALIQUOT_LINK_A'], aliquot['CREATED_ON'], aliquot['AMOUNT'], aliquot['U_I_AMOUNT'], aliquot['U_ORGAN'])

    return None

if __name__ == '__main__': main(sys.argv[1:])
