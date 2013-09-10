#!/usr/bin/env python

import sys
import login
from ora_sql import _format_entry

def main(argv):
    db = login.get_db('trost_phenotyping')
#    q = """
#SELECT pe.entity_id, e.parameter_dt, e.PO_id, definition FROM project_entity pe
#JOIN test_mpiscore_entities e ON e.OrganID = pe.entity_id
#WHERE pe.project_id = 1
#"""
    q = """ SELECT OrganID, IF(char_length(parameter_dt) = 0, parameter, parameter_dt) AS parameter_dt, PO_id, definition, parameter FROM test_mpiscore_entities """
    db.query(q)
    rows = db.store_result().fetch_row(how=0, maxrows=0)
    for data in rows:
        stripped_data = []
        for d in data:
            if 'rstrip' in dir(d): # string-like object, ok, lets replace stuff!
                d = d.rstrip('\n').rstrip('\r')
            stripped_data.append(d)

        data = _format_entry(stripped_data)
        print """
        INSERT INTO `entities` (id, name, PO, definition)
        VALUES (%s, %s, %s, %s)
        ON DUPLICATE KEY UPDATE
        name = VALUES(name),
        PO = VALUES(PO),
        definition = VALUES(definition);
        """ % (data[0], data[1], data[2], data[3])

        # insert into the internationalization table: en_us
        print """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content)
        VALUES ('en_us', 'Entity', %s, 'name', %s)
        ON DUPLICATE KEY UPDATE
        locale = VALUES(locale),
        model = VALUES(model),
        foreign_key = VALUES(foreign_key),
        field = VALUES(field),
        content = VALUES(content);
        """ % (data[0], data[4])

        # insert into the internationalization table: de_de
        print """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content)
        VALUES ('de_de', 'Entity', %s, 'name', %s)
        ON DUPLICATE KEY UPDATE
        locale = VALUES(locale),
        model = VALUES(model),
        foreign_key = VALUES(foreign_key),
        field = VALUES(field),
        content = VALUES(content);
        """ % (data[0], data[1])

if __name__ == '__main__':
    main(sys.argv[1:])
