#!/usr/bin/python

import sys
import datetime

import login
_odb = login.get_ora_db()

# formats a returned results set (e.g. adds quotes to strings, makes NULL out of None)
_format = True

aliquots_q = """
SELECT aliquot_id, u_culture from aliquot_user where u_culture = :study_id
""".strip()

# TODO please review this piece of code .. is it stil necessary?
aliquots_trost_q = """
select au.aliquot_id, au.u_aliquot_link_a, au.u_organ, a.created_on, a.amount, au.u_i_amount, a.amount
from lims.aliquot_user au, lims.aliquot a
where a.aliquot_type = 'MS Component'
and au.aliquot_id = a.aliquot_id


select sample_id from aliquot a, aliquot_user au where a.aliquot_id = (select u_aliquot_link_a from aliquot a, aliquot_user au where a.sample_id = (select sample_id from aliquot where aliquot_id = 1182435) and a.aliquot_id = au.aliquot_id and not au.u_aliquot_link_a is null) and au.aliquot_id = a.aliquot_id



select aliquot.aliquot_id, aliquot.name, aliquot.aliquot_type, aliquot.sample_id, aliquot_user.u_i_amount, aliquot.unit_id from aliquot, aliquot_user where aliquot.sample_id in ( select sample.sample_id from sample, sample_user where sample.sample_type = 'MS' and sample_user.u_project = 'TROST' and sample.sample_id=sample_user.sample_id) and  aliquot.aliquot_type = 'Test' and aliquot.aliquot_id = aliquot_user.aliquot_id


select aliquot.aliquot_id, aliquot.name, aliquot_user.U_aliquot_link_A as plant, aliquot_user.u_sampled_on, aliquot.sample_id, aliquot_user.u_i_amount, aliquot.unit_id from aliquot, aliquot_user where aliquot.sample_id in ( select sample_id from sample_user where U_project = 'TROST') and  aliquot.aliquot_type = 'MS Component' and aliquot.aliquot_id = aliquot_user.aliquot_id




select * from (select aliquot.aliquot_id, aliquot.name, aliquot.aliquot_type, aliquot.sample_id, aliquot_user.u_i_amount, aliquot.unit_id from aliquot, aliquot_user where aliquot.sample_id in ( select sample.sample_id from sample, sample_user where sample.sample_type = 'MS' and sample_user.u_project = 'TROST' and sample.sample_id=sample_user.sample_id) and  aliquot.aliquot_type = 'Test' and aliquot.aliquot_id = aliquot_user.aliquot_id) Components
join (
select aliquot.aliquot_id, aliquot.name, aliquot_user.U_aliquot_link_A as plant, aliquot_user.u_sampled_on, aliquot.sample_id, aliquot_user.u_i_amount, aliquot.unit_id from aliquot, aliquot_user where aliquot.sample_id in ( select sample_id from sample_user where U_project = 'TROST') and  aliquot.aliquot_type = 'MS Component' and aliquot.aliquot_id = aliquot_user.aliquot_id) Aliquots on Components.sample_id = Aliquots.sample_id where Aliquots.sample_id = 865471;
""".strip()

culture_q = """
SELECT u_culture FROM aliquot_user WHERE aliquot_id = :aliquot_id
""".strip()

subspecies_q = """
select sample_user.u_subspecies_id, a.aliquot_id, a.name, aliquot_user.u_culture, a.description, a.location_id, a.sample_id as line_id
from aliquot a
join aliquot_user on a.aliquot_id = aliquot_user.aliquot_id
join study_user on study_user.study_id = aliquot_user.u_culture
left join sample_user on sample_user.sample_id = a.sample_id
where study_user.u_project = 'TROST'
AND a.aliquot_id = :aliquot_id
""".strip()

pedigree_subspecies_q = """
select plant_subspecies_id_single(a.aliquot_id) as subspecies_id, a.aliquot_id, a.name, au.u_culture from aliquot a, aliquot_user au, sample_user sau, study_user stu where a.aliquot_id = au.aliquot_id and sau.sample_id = a.sample_id and au.u_culture = stu.study_id and stu.u_project = 'TROST' and a.aliquot_id = :aliquot_id
""".strip()

#all_aliquot_info_q = """
#SELECT * FROM aliquot WHERE aliquot_id = :aliquot_id
#""".strip()

all_ext_aliquot_info_q = """
select au.aliquot_id, au.u_aliquot_link_a, au.u_organ, a.created_on, a.amount, au.u_i_amount, a.amount from lims.aliquot_user au right join lims.aliquot a on au.aliquot_id = a.aliquot_id where a.aliquot_id = :aliquot_id
""".strip()

# finally got a working query from Juergen - 121210
all_plant_info_q = """
select a.aliquot_id, a.name as aliquot, au.u_culture as culture,
a.sample_id as line, sau.u_subspecies_id as subspecies_id, a.created_on
from aliquot a, aliquot_user au, study s, study_user su, sample_user sau
where su.u_project in ('TROST', 'TROST2')
and au.u_culture = su.study_id
and su.study_id = s.study_id
and au.aliquot_id = a.aliquot_id
and sau.sample_id = a.sample_id
order by s.study_id desc,
a.aliquot_id desc
"""

plant_count_q = """
select count(*)
from aliquot a, aliquot_user au, study s, study_user su, sample_user sau
where su.u_project = 'TROST'
and au.u_culture = su.study_id
and su.study_id = s.study_id
and au.aliquot_id = a.aliquot_id
and sau.sample_id = a.sample_id
and a.aliquot_id = :aliquot_id
"""

all_dead_plant_info_q = """
select mapc.aliquot_id, a.name as aliquot, s.study_id as culture, 
mapc.old_culture as study_id, a.sample_id as line, su.u_subspecies_id as subspecies_id, a.created_on
from mpi_au_plant_c mapc, study s, aliquot a, sample_user su 
where old_culture in (select study_id from study_user where u_project in ('TROST', 'TROST2')) 
and new_culture is null
and s.study_id = mapc.old_culture
and a.aliquot_id = mapc.aliquot_id
and su.sample_id = a.sample_id
order by s.study_id desc,
a.aliquot_id desc
"""

dead_plant_count_q = """
select count(*)
from mpi_au_plant_c mapc, study s, aliquot a, sample_user su 
where old_culture in (select study_id from study_user where u_project in ('TROST', 'TROST2')) 
and new_culture is null
and s.study_id = mapc.old_culture
and a.aliquot_id = mapc.aliquot_id
and su.sample_id = a.sample_id
and mapc.aliquot_id = :aliquot_id
"""

all_samples_info_q = """
select a.sample_id, created_on, au.u_aliquot_link_a as plant_id
from aliquot a
join aliquot_user au on au.aliquot_id = a.aliquot_id
join sample_user  su on su.sample_id  = a.sample_id
where a.aliquot_type = 'MS Component'
and su.u_project in ('TROST', 'TROST2')
"""

sample_count_q = """
select count(*)
from aliquot a
join aliquot_user au on au.aliquot_id = a.aliquot_id
join sample_user  su on su.sample_id  = a.sample_id
where a.aliquot_type = 'MS Component'
and su.u_project = 'TROST'
and a.sample_id = :aliquot_id
"""

aliquot_count_q = """
select count(*)
from sample_user plant_line,
aliquot plant,
aliquot_user component_user,
aliquot Component,
aliquot test_aliquot,
sample_user trost_sample
where trost_sample.u_project = 'TROST'
and Component.aliquot_type = 'MS Component'
and Component.sample_id = test_aliquot.sample_id
and Component.aliquot_id = component_user.aliquot_id
and component_user.u_aliquot_link_a = plant.aliquot_id
and plant.sample_id = plant_line.sample_id
and test_aliquot.sample_id = trost_sample.sample_id
and Component.sample_id = trost_sample.sample_id
and test_aliquot.aliquot_id = :aliquot_id
"""

#all_aliquot_info_q = """
#select a.aliquot_id, au.u_aliquot_link_a as plant_id, a.created_on, a.amount, au.u_i_amount, au.u_organ
#from aliquot a
#join sample s on s.sample_id = a.sample_id
#join sample_user su on su.sample_id = s.sample_id
#join aliquot_user au on au.aliquot_id = a.aliquot_id
#where su.u_project = 'TROST'
#and  a.aliquot_type = 'MS Component' 
#"""

all_aliquot_info_q = """
select distinct test_aliquot.aliquot_id as aliquot,
test_aliquot.amount,
test_aliquot.unit_id,
component_user.u_aliquot_link_a as plant,
component_user.u_organ as organ,
plant.name,
plant_line.u_subspecies_id as subspecies_id,
component_user.u_sampled_on,
trost_sample.sample_id as MS_Sample
from sample_user plant_line,
aliquot plant,
aliquot_user component_user,
aliquot Component,
aliquot test_aliquot,
sample_user trost_sample
where trost_sample.u_project in ('TROST', 'TROST2')
and Component.aliquot_type = 'MS Component'
and Component.sample_id = test_aliquot.sample_id
and Component.aliquot_id = component_user.aliquot_id
and component_user.u_aliquot_link_a = plant.aliquot_id
and plant.sample_id = plant_line.sample_id
and test_aliquot.sample_id = trost_sample.sample_id
and Component.sample_id = trost_sample.sample_id
order by plant, aliquot
"""

# following q selects all cultures from all the plants - it's a rewrite of all_plant_info_q
all_cultures_q = """
select distinct su.study_id, s.description, su.u_location_id as location_id, s.name, su.u_condition as condition
from study_user su
join study s on s.study_id = su.study_id
where u_project = 'TROST'
"""

# looks up all information of a culture
culture_info_q = """
select distinct study.study_id as Study_Id, description as Description, u_location_id as location_id, study.name as Name, u_condition as condition 
from aliquot a
join sample s on s.sample_id = a.sample_id
join sample_user su on su.sample_id = s.sample_id
join aliquot_user au on au.aliquot_id = a.aliquot_id
join STUDY_USER on study_user.study_id = au.u_culture
join STUDY ON study.study_id = study_user.study_id
where su.u_project = 'TROST' and a.aliquot_type = 'Plant'
and study.study_id = :study_id
"""

# following q is supposed to fetch all cultures of TROST, but it doesn't  :/
#old_cultures_q = """
#select study.study_id as Study_Id, description as Description, u_location_id as location_id, study.name as Name, u_condition as condition from STUDY_USER
#join STUDY ON study.study_id = study_user.study_id
#where u_project = 'TROST'
#and u_location_id > 4000
#"""

all_plantlines_q = """
select sample_id, name, description from sample
where sample.sample_id IN
( SELECT aliquot.sample_id from aliquot,
        aliquot_user, study_user
        where aliquot.aliquot_id = aliquot_user.aliquot_id
        AND aliquot_user .u_culture  = study_user.study_id
        and study_user.u_project = :project)
"""

def _format_entry(entry):
    """ This is a really really ugly workaround... 
    """
    formatted = []
    for x in entry:
        if x == None:
            formatted.append("NULL")
        elif isinstance(x, str):
            formatted.append("'%s'" % x)
        elif isinstance(x, unicode):
            formatted.append("'%s'" % x)
        elif isinstance(x, datetime.datetime):
            formatted.append("'%s'" % x)
        else:
            formatted.append(x)
    return formatted

"""
check if a certain ID exists in the DB
"""
def exists(table, id, id_name = 'id', q = "SELECT count(*) FROM %s WHERE %s = :id"):
    c = _odb.cursor()
    c.execute(q % (table, id_name), {'id': id})
    rows = c.fetchall()
    if len(rows) > 0:
        if rows[0][0] > 0:
            return True
    return False

def set_formatting(value):
    global _format
    _format = value

def _fetch_assoc(q, **params):
    c = _odb.cursor()
    c.execute(q, params)
    rows = c.fetchall()
    # http://stackoverflow.com/questions/4468071/how-can-i-make-cx-oracle-bind-the-results-of-a-query-to-a-dictionary-rather-than
    desc = [d[0] for d in c.description]
    if len(rows) > 0:
        rs = []
        if _format:
            rs = [dict(zip(desc, _format_entry(row))) for row in rows]
        else:
            rs = [dict(zip(desc, row)) for row in rows]
        return rs
    return None

def get_all_cultures():
    return _fetch_assoc(all_cultures_q)

def get_sample_description_of(aliquot):
    return _fetch_assoc(all_aliquot_info_q, {'aliquot_id': aliquot})

def get_ext_sample_description_of(aliquot):
    return _fetch_assoc(all_ext_aliquot_info_q, {'aliquot_id': aliquot})

def is_plant(id):
    c = _odb.cursor()
    c.execute(plant_count_q, { 'aliquot_id': id })
    exists = c.fetchone()
    return exists != None and exists[0] > 0

def was_plant(id):
    c = _odb.cursor()
    c.execute(dead_plant_count_q, { 'aliquot_id': id })
    exists = c.fetchone()
    return exists != None and exists[0] > 0

def is_sample(id):
    c = _odb.cursor()
    c.execute(sample_count_q, { 'aliquot_id': id })
    exists = c.fetchone()
    return exists != None and exists[0] > 0;

def is_aliquot(id):
    c = _odb.cursor()
    c.execute(aliquot_count_q, { 'aliquot_id': id })
    exists = c.fetchone()
    return exists != None and exists[0] > 0;

def get_all_aliquots_info():
    return _fetch_assoc(all_aliquot_info_q)

def get_all_plantlines(project):
    return _fetch_assoc(all_plantlines_q, project=project)

def get_all_plants_info():
    return _fetch_assoc(all_plant_info_q)

def get_all_dead_plants_info():
    return _fetch_assoc(all_dead_plant_info_q)

def get_all_samples_info():
    return _fetch_assoc(all_samples_info_q)

def get_plant_information(aliquot_id):
    rs = _fetch_assoc(q=subspecies_q, aliquot_id=aliquot_id)
    if rs != None and len(rs) > 0:
        return rs[0]
    return rs

def get_culture_information(study_id):
    rs = _fetch_assoc(q=culture_info_q, study_id=study_id)
    if rs != None and len(rs) > 0:
        return rs[0]
    return rs

def get_subspecies_information(subspecies_id):
    rs = _fetch_assoc(q='SELECT name, description FROM u_subspecies', subspecies_id=subspecies_id)
    if rs != None and len(rs) > 0:
        return rs[0]
    return rs

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

def get_aliquots_trost():
    c = _odb.cursor()
    c.execute(aliquots_trost_q)
    rows = c.fetchall()
    desc = [d[0] for d in c.description]
    if len(rows) > 0:
        rs = [dict(zip(desc, _format_entry(row))) for row in rows]
        return rs
    return None

def get_locations(ids=None):
    c = _odb.cursor()
    q = " SELECT LOCATION_ID, NAME, ELEVATION FROM location "
    if ids != None:
        q += " WHERE LOCATION_ID IN (%s) " % (",".join([ str(id) for id in ids ]))

    c.execute(q)
    rows = c.fetchall()
    desc = [ d[0] for d in c.description ]
    if len(rows) > 0:
        rs = [ dict(zip(desc, _format_entry(row))) for row in rows ]
        return rs
    return None


###
def main(argv):
    return None

if __name__ == '__main__': main(sys.argv[1:])
