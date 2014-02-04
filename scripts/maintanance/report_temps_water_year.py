#!/usr/bin/env python

import sys

base_query = """
(select count(*) as %(table)s%(year)d, l.name as location_name, l.id from locations l
left join %(table)s t on t.location_id = l.id
where
YEAR(t.datum) = %(year)d
OR YEAR(t.datum) IS NULL
group by l.id
order by l.id) as rs%(table)s%(year)d
"""

def main(argv):
    queries = []
    prev_year = None
    prev_table = None
    columns = []
    for year in argv:
        year = int(year)
        for table in ['irrigation', 'precipitation', 'temperatures']:
            q = base_query % { 'table': table, 'year': year }
            if prev_year != None:
                q = q + 'ON rs%(prev_table)s%(prev_year)d.id = rs%(table)s%(year)d.id' % \
                    { 'prev_table': prev_table, 'prev_year': prev_year, 'table': table, 'year': year }
            queries.append(q)

            columns.append('%(table)s%(year)d' % { 'table': table, 'year': year })
            prev_year = year
            prev_table = table

    if len(columns) > 0:
        inner_columns = columns[:]
        inner_columns[0] = 'rs%s.*' % inner_columns[0]
        q = "select l.name as location_name, %s from locations l join (select %s from %s) as e on e.id = l.id" % ( ",".join(columns), ",".join(inner_columns),  " left join ".join(queries))
        print q

if __name__ == '__main__': main(sys.argv[1:])


