#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def format(aliquot):

    rs = """
    INSERT INTO `aliquots` (id, sample_date, amount, amount_unit, organ)
    VALUES (%s, %s, %s, %s, %s)
    ON DUPLICATE KEY UPDATE
    sample_date=VALUES(sample_date),
    amount=VALUES(amount),
    amount_unit=VALUES(amount_unit),
    organ=VALUES(organ);
    """ % (
        aliquot['ALIQUOT'],
        aliquot['U_SAMPLED_ON'],
        aliquot['AMOUNT'],
        aliquot['UNIT_ID'],
        aliquot['ORGAN']
    )

    rs += """
    INSERT INTO `aliquot_plants` (aliquot_id, plant_id)
    VALUES (%s, %s)
    ON DUPLICATE KEY UPDATE
    aliquot_id=VALUES(aliquot_id),
    plant_id=VALUES(plant_id);
    """ % (
        aliquot['ALIQUOT'],
        aliquot['PLANT']
    )

    rs += """
    INSERT INTO `aliquot_samples` (aliquot_id, sample_id)
    VALUES (%s, %s)
    ON DUPLICATE KEY UPDATE
    aliquot_id=VALUES(aliquot_id),
    sample_id=VALUES(sample_id);
    """ % (
        aliquot['ALIQUOT'],
        aliquot['MS_SAMPLE']
    )

    return rs

def main(argv):

    aliquots = ora_sql.get_all_aliquots_info()

    print "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;"
    for aliquot in aliquots:
        print format(aliquot)
    print "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;"

if __name__ == '__main__': main(sys.argv[1:])
