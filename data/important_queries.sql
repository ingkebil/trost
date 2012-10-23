-- get all plants
select count(*) from aliquot, aliquot_user where aliquot.sample_id in ( select sample.sample_id from sample, sample_user where sample_user.u_project = 'TROST' and sample.sample_id=sample_user.sample_id) and  aliquot.aliquot_type = 'Plant' and aliquot.aliquot_id = aliquot_user.aliquot_id

-- list all aliquot_type's in project TROST
select count(*), aliquot.aliquot_type
from aliquot, aliquot_user
where aliquot.sample_id in (
    select sample.sample_id from sample, sample_user where sample_user.u_project = 'TROST' and sample.sample_id=sample_user.sample_id
)
and aliquot.aliquot_id = aliquot_user.aliquot_id
group by aliquot.aliquot_type

-- get plant_id from an aliquot_id
select sample_id from aliquot a where a.aliquot_id = (
    select distinct u_aliquot_link_a from aliquot a, aliquot_user au where a.sample_id = (
        select sample_id from aliquot where aliquot_id = 1182435
    )
    and a.aliquot_id = au.aliquot_id and not au.u_aliquot_link_a is null
)

-- get aliquot_ids from a plant_id
select a.aliquot_id from aliquot a
join aliquot a_mn       on a_mn.sample_id = a.sample_id
join aliquot_user au_mn on au_mn.aliquot_id = a_mn.aliquot_id
join aliquot a_end      on a_end.aliquot_id = au_mn.u_aliquot_link_a
where a_end.sample_id = 860206

-- fill in the plants table based on LIMS data
select a.aliquot_id as plant_id, a.sample_id as line_id, a.location_id, a.name, su.u_subspecies_id, a.description, au.u_culture as culture_id
from aliquot a
join sample s on s.sample_id = a.sample_id
join sample_user su on su.sample_id = s.sample_id
join aliquot_user au on au.aliquot_id = a.aliquot_id
where su.u_project = 'TROST'
and  a.aliquot_type = 'Plant'

-- fill the aliquots table based on LIMS data
select a.aliquot_id, au.u_aliquot_link_a as plant_id, a.created_on, a.amount, au.u_i_amount, au.u_organ
from aliquot a
join sample s on s.sample_id = a.sample_id
join sample_user su on su.sample_id = s.sample_id
join aliquot_user au on au.aliquot_id = a.aliquot_id
where su.u_project = 'TROST'
and  a.aliquot_type = 'MS Component' 
