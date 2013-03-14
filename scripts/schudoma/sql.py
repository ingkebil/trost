#!/usr/bin/python
# -*- coding: utf8 -*-

import sys

import login
the_db = login.get_db()

USE_DB = 'USE %s;'
DROP_TABLE = 'DROP TABLE IF EXISTS %s;'
CREATE_TABLE = 'CREATE TABLE %s(\n%s\n) ENGINE=InnoDB DEFAULT CHARSET=utf8;' 
ALTER_TABLE  = 'ALTER TABLE %s %s;' # table name, ADD column TYPE
INSERT_STR = 'INSERT INTO %s VALUES %s;\n'
REPLACE_STR = 'REPLACE INTO %s VALUES %s;\n'
"""
INSERT_SELECT_STR = ''
insert into plants (id, location_id) select NULL, locations.id from locations where locations.limsid = 1111;
"""

INSERT_PLANTS2_STR = """
INSERT INTO plants2 
(id, aliquot, name, subspecies_id, location_id, culture_id, sampleid,
description, created)
SELECT NULL, %s, %s, subspecies.id, locations.id, %s, %s, '', ''
FROM subspecies, locations
WHERE subspecies.limsid = %s AND locations.limsid = %s;
""".strip()


""" SQL Queries """

location_query = """
SELECT id, limsid FROM locations
""".strip()

value_query = """
select `values`.id, content, value from `values`
join i18n on foreign_key = values.id
where locale = 'en_us'
and `model` = 'value'
and attribute = 'Behandlung'
and field = 'value'
""".strip()

cultures_q = """
SELECT limsstudyid, id FROM cultures
""".strip()

plant_ids_q = """
SELECT aliquot, id FROM plants
""".strip()

subspecies_q = """
SELECT limsid, id FROM subspecies
""".strip()

missing_plants_q = """
select aliquotid from starch_yield where aliquotid not in (select 
aliquotid from starch_yield, plants where location_id=%s AND 
aliquotid=plants.aliquot order by cultivar) AND location_id=%s;
""".strip()

get_value_id_q = """
SELECT id FROM `values` WHERE value=%s;
""".strip()

starch_yield_plants_q = """
select aliquotid from starch_yield where cultivar = %s;
""".strip()

def get_missing_plants(location_id):
    q    = the_db.query(missing_plants_q % (location_id, location_id))
    data = the_db.store_result().fetch_row(how=0, maxrows=0)
    rs   = [d[0] for d in data]
    return rs

def _get_table(query, key_key, pk_key='id'):
    query = the_db.query(query)
    data = the_db.store_result().fetch_row(how=1, maxrows=0)
    #print data
    rs = dict() 
    for d in data:
        #cast_key_key = 'None'
        ## lame casting solution
        #if type(d[key_key]) is str: cast_key_key = int(d[key_key])
        #rs[cast_key_key] = int(d[pk_key])
        rs[d[key_key]] = d[pk_key]
    return rs

def get_subspecies():
    return _get_table(subspecies_q, 'limsid')

def get_cultures():
    return _get_table(cultures_q, 'limsstudyid')

def get_plants():
    return _get_table(plant_ids_q, 'aliquot')

def get_locations():
    return _get_table(location_query, 'limsid')

def get_raws():
    return _get_table("SELECT * FROM raws", 'filename', 'data')

def get_plants_of_file(raw_id):
    #q = """select distinct plants.aliquot from raws
    #join phenotype_raws on phenotype_raws.raw_id = raws.id
    #join phenotypes on phenotypes.id = phenotype_raws.phenotype_id
    #join samples on samples.id = phenotypes.sample_id
    #join plants on plants.id = samples.plant_id
    #where raws.id = %s"""
    q = """select distinct samples.plants_id from phenotype_raws
    join phenotypes on phenotypes.id = phenotype_raws.phenotype_id
    join samples on samples.id = phenotypes.sample_id
    where phenotype_raws.raw_id = %s
    """
    c = the_db.cursor()
    c.execute(q, (raw_id,) )
    data = c.fetchall()
    plant_ids = []
    if len(data) > 0:
        plant_ids = [ d[0] for d in data ]
    return plant_ids

def get_samples_of_file(raw_id):
    #q = """select distinct samples.name from raws
    #join phenotype_raws on phenotype_raws.raw_id = raws.id
    #join phenotypes on phenotypes.id = phenotype_raws.phenotype_id
    #join samples on samples.id = phenotypes.sample_id
    #where raws.id = %s"""
    q = """select distinct phenotypes.sample_id from phenotype_raws
    join phenotypes on phenotypes.id = phenotype_raws.phenotype_id
    where phenotype_raws.raw_id = %s"""
    c = the_db.cursor()
    c.execute(q, (raw_id,) )
    data = c.fetchall()
    ids = []
    if len(data) > 0:
        ids = [ d[0] for d in data ]
    return ids

def get_values():
    query = the_db.query(value_query)
    data = the_db.store_result().fetch_row(how=1, maxrows=200)
    id_of = dict()
    for d in data:
        id_of[str(d['content'])] = int(d['id'])
        id_of[str(d['value'])]   = int(d['id'])
    id_of[''] = '0' # add the empty value
    return id_of

def get_value_id(value):
    c = the_db.cursor()
    c.execute(get_value_id_q, (value,))
    data = c.fetchall()
    if len(data) > 0:
        if len(data[0]) > 0:
            return data[0][0]
    return None

def get_plants_culivar_of(cultivar):
    c = the_db.cursor()
    c.execute(starch_yield_plants_q, (cultivar,))
    data = c.fetchall()
    rs   = [d[0] for d in data]
    return rs

def insert(table, params):
    c = the_db.cursor()
    
    q = """INSERT INTO `%s` (`%s`) VALUES (%s);""" % (table, '`,`'.join(params.keys()), ','.join([ '%s' for x in xrange(len(params)) ]) )
    #c.execute('set profiling = 1')
    #try:
    #    rs = c.execute(q, params.values())
    #except Exception:
    #    c.execute('show profiles')
    #    for r in c:
    #        print r
    #finally:
    #    c.execute('set profiling = 0')

    rs = c.execute(q, params.values())
    return rs

def lastrowid():
    return the_db.insert_id()
    #return the_db.cursor().lastrowid

def commit():
    the_db.commit()

def exists(table, id, id_key = 'id'):
    c = the_db.cursor()
    q = 'select count(*) from %s where %s = ' % (table, id_key)
    c.execute(q + '%s', (id,))
    d = c.fetchall()
    if len(d) > 0:
        if d[0][0] > 0:
            return True
    return False

def fetch(table, id, id_key='id'):
    c = the_db.cursor()
    q = 'select * from %s where %s = ' % (table, id_key)
    c.execute(q + '%s', (id,))
    rows = c.fetchall()
    desc = [d[0] for d in c.description]
    if len(rows) > 0:
        return [dict(zip(desc, row)) for row in rows][0]
    return False

def fetch_all(table, where, q=None):
    c = the_db.cursor()
    keys = where.keys()
    if q==None:
        where_params = ' and '.join([ '%s=%s' % (k, '%s') for k in keys ])
        q = 'select * from %s where %s' % (table, where_params)
    c.execute(q, [ where[ key ] for key in keys ] )
    rows = c.fetchall()
    desc = [d[0] for d in c.description]
    if len(rows) > 0:
        return [dict(zip(desc, row)) for row in rows]
    return []

def count(table, where = None):
    c = the_db.cursor()
    where_str = ''
    if where:
        where_str = " where %s" % ' and '.join([ '%s=%s' % (k, '%s') for k in where.keys() ])
    q = "select count(*) from `%s`%s" % (table, where_str)
    if where:
        c.execute(q, where.values())
    else:
        c.execute(q)

    rs = c.fetchone()
    if rs:
        return rs[0]
    else:
        return None

def get_tables():
    c = the_db.cursor()
    q = 'show tables from %s' % login.DB_NAME
    c.execute(q)
    rows = c.fetchall()
    if len(rows) > 0:
        return [ row[0] for row in rows ]
    return False

"""
table: table name
where: { attr: value }
params: { attr: value }
"""
def update(table, where, params):
    c = the_db.cursor()
    # ok, it is a bit annoying that the MySQL driver required %s as placeholders
    where_params = ','.join([ '%s=%s' % (k, '%s') for k in where.keys() ])
    set_params   = ' and '.join([ '%s=%s' % (k, '%s') for k in params.keys() ])
    q = 'update %s set %s where %s' % ( table, set_params, where_params)
    return c.execute(q, params.values() + where.values())


""" Output """

def write_sql_alter(db_name, table_name, table, out=sys.stdout):
    out.write('%s\n' % USE_DB % db_name)
    out.write('%s\n' % (ALTER_TABLE% (table_name,
                                        ',\n'.join(["ADD %s" % entry for entry in table]))))

def write_sql_header(db_name, table_name, table, out=sys.stdout):
    out.write('%s\n' % USE_DB % db_name)
    out.write('%s\n' % DROP_TABLE % table_name)
    out.write('%s\n' % (CREATE_TABLE % (table_name,
                                        ',\n'.join(table))))
    pass

def format_entry(entry):
    """ This is a really really ugly workaround... """
    formatted = []
    for x in entry:
        if isinstance(x, str) and x != 'NULL':
            formatted.append("'%s'" % x)
        else:
            formatted.append(x)
    # return '(%s)' % ','.join(map(str, formatted))
    return formatted

def prepare_sql_table(data, columns_d, add_id=False):
    rows = []
    # as we check the attr of a DO, we need to make sure we _ the attr we're looking for
    columns_d_ = {}
    for key,value in columns_d.items():
        columns_d_[ key.replace(' ', '_') ] = columns_d[ key ]
    for dobj in data:
        row = []
        for key, val in columns_d_.items():
            if len(val) == 4: # it has a lookup function, use it
                row.append( val[:-1] + val[3](dobj, key) )
            elif hasattr(dobj, key) and getattr(dobj, key) != '':
#                if len(val) == 4: # ok, it has a lookup function for the value, so use it
#                    if val[3] == 'custom':
#                        val = val[:3]
#                    else:
#                        print locals()[ val[3] ]( getattr(dobj, key) )
#                        val = val[:3] + locals()[ val[3] ]( getattr(dobj, key) )
                row.append(val + (getattr(dobj, key),))
            else:
                row.append(val[:-1] + (str, 'NULL'))
        if add_id:
            row = [(-1, 'id', str, 'NULL')] + row # add the id
        rows.append(sorted(row))
    return rows


def write_standard_sql_table(rows, table_name='DUMMY', out=sys.stdout, insert=True):
    for row in rows:
        try:       
            formatted = format_entry([x[2](x[3]) for x in row])
            entry = '(%s)' % ','.join(map(str, formatted))
            if insert:
                out.write(INSERT_STR % (table_name, entry))
            else:
                out.write(REPLACE_STR % (table_name, entry))
        except:
            sys.stderr.write('EXC: %s\n' % row)
            sys.exit(1)
    pass

# legacy support
def write_sql_table(data, columns_d, table_name='DUMMY', out=sys.stdout, add_id=False, insert=True):
    write_standard_sql_table(prepare_sql_table(data, columns_d, add_id),
                             table_name=table_name, out=out, insert=insert)
    pass
  
def write_update_sql(): pass
  

###
def main(argv):
    return None

if __name__ == '__main__': main(sys.argv[1:])
