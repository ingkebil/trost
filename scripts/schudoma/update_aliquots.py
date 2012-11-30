#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def format(*params):
    return "REPLACE into `aliquots` VALUES (%s, %s, %s, %s, %s, %s);" % params

def main(argv):

    aliquots = ora_sql.get_all_aliquots_info()

    for aliquot in aliquots:
        print format(
            aliquot['ALIQUOT'],
            aliquot['PLANT'],
            aliquot['U_SAMPLED_ON'],
            aliquot['AMOUNT'],
            aliquot['UNIT_ID'],
            aliquot['ORGAN']
        )

if __name__ == '__main__': main(sys.argv[1:])


"""

"""
