#!/usr/bin/python

import os
import sys
import math

import login
_odb = login.get_ora_db()

aliquots_q = """
SELECT aliquot_id, u_culture from aliquot_user where u_culture = :study_id
""".strip()

culture_q = """
SELECT u_culture FROM aliquot_user WHERE aliquot_id = :aliquot_id
""".strip()

subspecies_q = """
select sample_user.u_subspecies_id, aliquot.aliquot_id, aliquot.name, aliquot_user.u_culture
from aliquot
join aliquot_user on aliquot.aliquot_id = aliquot_user.aliquot_id
join study_user on study_user.study_id = aliquot_user.u_culture
left join sample_user on sample_user.sample_id = aliquot.sample_id
where study_user.u_project = 'TROST'
AND aliquot.aliquot_id = :aliquot_id
""".strip()

pedigree_subspecies_q = """
select plant_subspecies_id_single(a.aliquot_id) as subspecies_id, a.aliquot_id, a.name, au.u_culture from aliquot a, aliquot_user au, sample_user sau, study_user stu where a.aliquot_id = au.aliquot_id and sau.sample_id = a.sample_id and au.u_culture = stu.study_id and stu.u_project = 'TROST' and a.aliquot_id = :aliquot_id
""".strip()

all_aliquot_info_q = """
SELECT * FROM aliquot WHERE aliquot_id = :aliquot_id
""".strip()

def format_entry(entry):
    """ This is a really really ugly workaround... """
    formatted = []
    for x in entry:
        if x == None:
            formatted.append("NULL")
        elif isinstance(x, str):
            formatted.append("'%s'" % x)
        else:
            formatted.append(x)
    return formatted

def get_sample_description_of(aliquot):
    c = _odb.cursor()
    c.execute(all_aliquot_info_q, {'aliquot_id': aliquot})
    rows = c.fetchall()
    # http://stackoverflow.com/questions/4468071/how-can-i-make-cx-oracle-bind-the-results-of-a-query-to-a-dictionary-rather-than
    desc = [d[0] for d in c.description]
    if len(rows) > 0:
        rs = [dict(zip(desc, format_entry(row))) for row in rows]
        return rs[0]
    return None

def get_plant_information(aliquot_id):
    c = _odb.cursor()
    c.execute(subspecies_q, dict(aliquot_id=aliquot_id))
    row = c.fetchall()
    if len(row) > 0:
        return {
            'name'          : row[0][2],
            'aliquot_id'    : row[0][1],
            'subspecies_id' : row[0][0],
            'culture_id'    : row[0][3],
        }
    return None

def get_pedigree_plant_information(aliquot_id):
    c = _odb.cursor()
    c.execute(pedigree_subspecies_q, dict(aliquot_id=aliquot_id))
    row = c.fetchall()
    if len(row) > 0:
        return {
            'name'          : row[0][2],
            'aliquot_id'    : row[0][1],
            'subspecies_id' : row[0][0],
            'culture_id'    : row[0][3],
        }
    return None

def get_subspecies_id(aliquot_id):
    c = _odb.cursor()
    c.execute(subspecies_q, dict(aliquot_id=aliquot_id))
    row = c.fetchall()
    if len(row) > 0:
        if len(row[0]) > 0:
            return row[0][0]
    return None

def get_culture_id(aliquot_id):
    c = _odb.cursor()
    c.execute(culture_q, dict(aliquot_id=aliquot_id))
    row = c.fetchall()
    if len(row) > 0:
        if len(row[0]) > 0:
            return row[0][0]
    return None

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
