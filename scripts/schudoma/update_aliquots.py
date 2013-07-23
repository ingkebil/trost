#!/usr/bin/python

import sys
import ora_sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'aliquots'
"""

def format(aliquot):

    # add the aliquot information
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

    # connect this aliquot to its plants
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

    # connect this aliquot to its samples
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

    # add the 'amount' information to the phenotypes table
    # Also, removed the VALUES() part of the UPDATE, so that no rows would be affected on duplication.
    # http://stackoverflow.com/questions/2366813/on-duplicate-key-ignore
    #rs += """
    #INSERT INTO `phenotypes` (program_id, date, time, entity_id, value_id, number)
    #VALUES (%s,%s,%s,%s,%s,%s)
    #ON DUPLICATE KEY UPDATE
    #program_id=program_id,
    #date=date,
    #time=time,
    #entity_id=entity_id,
    #value_id=value_id,
    #number=number;
    #""" % (
    #    5,
    #    aliquot['U_SAMPLED_ON'],
    #    aliquot[''],
    #    aliquot[''],
    #    aliquot[''],
    #    aliquot[''],
    #)

    return rs

def main(argv):

    aliquots = ora_sql.get_all_aliquots_info()

    #print "INSERT INTO `programs` (id, name) VALUES (5, 'Imported from LIMS') ON DUPLICATE KEY IGNORE;"
    for aliquot in aliquots:
        print format(aliquot)

if __name__ == '__main__': main(sys.argv[1:])
