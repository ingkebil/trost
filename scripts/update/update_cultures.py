#!/usr/bin/python

import sys
import ora_sql

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

    cultures = ora_sql.get_all_cultures()

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

if __name__ == '__main__': main(sys.argv[1:])
