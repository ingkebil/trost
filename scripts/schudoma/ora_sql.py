#!/usr/bin/python

import os
import sys
import math

import login
_odb = login.get_ora_db()

aliquots_q = """
SELECT aliquot_id, u_culture from aliquot_user where u_culture = :study_id
""".strip()

def get_aliquots(limsstudy_id):
    c = _odb.cursor()
    c.execute(aliquots_q, dict(study_id=limsstudy_id))
    rows = c.fetchall()
#    for row in rows:
#        print int(row[0])
    return [row[0] for row in c]

###
def main(argv):
    return None

if __name__ == '__main__': main(sys.argv[1:])
