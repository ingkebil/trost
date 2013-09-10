#!/usr/bin/env python
# -*- coding: utf8 -*-

import sys
import login
from ora_sql import _format_entry

def main(argv):
    db = login.get_db('trost_phenotyping')
#    q = """
#SELECT value_id, attribut_D, wert_D from project_value pv
#JOIN test_mpiscore_values v on v.ValueID = pv.value_id
#WHERE pv.project_id = 1
#"""

    q = """
SELECT ValueID, attribut_D, wert_D, attribut_E, `value` FROM test_mpiscore_values
"""
    db.query(q)
    rows = db.store_result().fetch_row(how=0, maxrows=0)
    for data in rows:
        stripped_data = []
        for d in data:
            if 'rstrip' in dir(d): # string like object, ok, lets replace stuff!
                d = d.rstrip('\n').rstrip('\r')
            stripped_data.append(d)

        data = _format_entry(stripped_data)
        rs = """ INSERT INTO `values` (id, attribute, `value`) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE attribute = VALUES(attribute), `value` = VALUES(`value`);
        """ % (data[0], data[1], data[2])

        # there is a unique constraint on local,model,foreign_key,field
        # meaning that when that is found, only content should be updated
        rs += """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content) VALUES ('en_us', 'Value', %s, 'attribute', %s) ON DUPLICATE KEY UPDATE content=VALUES(content);
        """ % (data[0], data[3])

        rs += """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content) VALUES ('de_de', 'Value', %s, 'attribute', %s) ON DUPLICATE KEY UPDATE content=VALUES(content);
        """ % (data[0], data[1])

        rs += """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content) VALUES ('en_us', 'Value', %s, 'value', %s) ON DUPLICATE KEY UPDATE content=VALUES(content);
        """ % (data[0], data[4])

        rs += """
        INSERT INTO `i18n` (locale, model, foreign_key, field, content) VALUES ('de_de', 'Value', %s, 'value', %s) ON DUPLICATE KEY UPDATE content=VALUES(content);
        """ % (data[0], data[2])

        print rs.encode('utf-8')

if __name__ == '__main__':
    main(sys.argv[1:])
