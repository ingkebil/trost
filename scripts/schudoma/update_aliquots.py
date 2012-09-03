#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def main(argv):

    aliquots = ora_sql.get_all_aliquots_info()

    for aliquot in aliquots:
        print ','.join(str(x) for x in [
            aliquot['ALIQUOT_ID'],
            aliquot['PLANT_ID'],
            aliquot['CREATED_ON'],
            aliquot['AMOUNT'],
            aliquot['U_I_AMOUNT'],
            aliquot['U_ORGAN'] ]
        )

if __name__ == '__main__': main(sys.argv[1:])


"""

"""
