#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
import sql
import ora_sql

def main(argv):

    plant_ids = [
        1166839, 1166967, 1166968, 1166969, 1166970, 1166971, 1166972, 1167110, 1167123, 1167124, 1167125, 1167126, 1167127, 1167128, 1167129, 1167130, 1167131, 1167132,
        1170324, 1170325, 1170326, 1170327, 1170328, 1170329, 1170330, 1170331,
        1173582, 1173583, 1173584, 1173585, 1173598, 1173599, 1173600, 1173601, 1173750, 1173751, 1173752, 1173753, 1173774, 1173775, 1173776, 1173777
    ]

    for plant in plant_ids:
        if ora_sql.is_plant(plant):
            print "%d is a live plant" % plant
        elif ora_sql.was_plant(plant):
            print "%d was a plant" % plant
        else:
            print "%d UNKNOWN" % plant

        tables = ['phenotype_plants', 'sample_plants']
        for table in tables:
            count = sql.count(table, {'plant_id': plant })
            if count > 0:
                print "%s contains %d plants" % (table, count)

        count = sql.count('aliquots', {'plantid': plant })
        if count > 0:
            print "%s contains %d plants" % ('aliquots', count)


if __name__ == '__main__':
    main(sys.argv[1:])
