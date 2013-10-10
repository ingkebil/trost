#!/usr/bin/python

import sys
import ora_sql
import sql

"""
DB_NAME = 'trost_prod'
TABLE_NAME = 'cultures'
"""

def format_culture(*params):
    return """
        INSERT INTO `cultures` (id, name, `condition`, description, location_id)
        VALUES (%s,%s,%s,%s,%s)
        ON DUPLICATE KEY UPDATE
        name=VALUES(name),
        `condition`=VALUES(`condition`),
        description=VALUES(description),
        location_id=VALUES(location_id);
        """ % (params)

#        experiment_id=VALUES(experiment_id),
#        plantspparcelle=VALUES(plantspparcelle),
#        created=VALUES(created),
#        planted=VALUES(planted),
#        terminated=VALUES(terminated),

def format_location(*params):
    return """
    INSERT INTO `locations` (id, name, elevation)
    VALUES (%s, %s, %s)
    ON DUPLICATE KEY UPDATE
    name=VALUES(name),
    elevation=VALUES(elevation);
    """ % (params)

def main(argv):

    #cultures = ora_sql.get_all_cultures()

    cultures = ora_sql._fetch_assoc("""
select distinct st.study_id, st.description, l.location_id, 
l.name as location_name, st.name, stu.u_condition as condition
from study st
join study_user stu on stu.study_id = st.study_id
left join
(select s.entry_date as e_date, s.study_id as culture,
  /*get the newest location change (except the change to 'void')*/
  first_value(s.new_location) over (partition by study_id) as last_location
  from 
  /*culture audit table - contains all location changes*/
  (
    select entry_date, study_id, new_location from mpi_au_culture_l macl
    join location loc on loc.location_id = macl.new_location
    where loc.name not like ('void%')
    order by macl.study_id, macl.entry_date desc
  ) s
)  audits
on audits.culture = stu.study_id
/*retrieve location name/location id if there is any*/
left join location l on l.location_id = audits.last_location
where stu.u_project = 'TROST'
order by st.study_id desc
    """)

    # sometimes a new location has been added, so we should update those first
    location_ids = set([ culture['LOCATION_ID'] for culture in cultures ]);
    location_ids.remove('NULL') # we don't the null value -- but why would a culture have no location?
    location_ids = list(location_ids)

    locations = ora_sql.get_locations(location_ids)
    for l in locations:
        print format_location(
            l['LOCATION_ID'],
            l['NAME'],
            l['ELEVATION']
        )

    for c in cultures:
        print format_culture(
            c['STUDY_ID'],
            c['NAME'],
            c['CONDITION'],
            c['DESCRIPTION'],
            c['LOCATION_ID'],
        )

    # 13/10/10 - LIMS update changes Golm location name. This sets it back to 'Golm'
    print """
    INSERT INTO `locations` (id, name)
    VALUES (%s, %s)
    ON DUPLICATE KEY UPDATE
    name=VALUES(name);
    """ % (4537, "'" + sql.escape_string("Golm") + "'")

if __name__ == '__main__': main(sys.argv[1:])
