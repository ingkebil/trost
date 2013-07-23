#!/usr/bin/env python

import sql
import sys
import update_phenotypes as ph
import re

def main(argv):
    files = sql.fetch_all('raws', { '1': 1})

    for f in files:
        lines = []
        for line in re.split(r'\r\n', f['data']):
            line = re.split(r'\t|;', line)
            if len(line) >= 11:
                line = ph.preprocess_line(line)
                lines.append(line)

        count = 0
        for line in lines:
            program_id = ph.get_program_id(line)
            plant_id_pos = { 1: 7, 2: 3 }[ program_id ]
            line_plant_id = line[ plant_id_pos ]

            try:
                #ids = sql.get_plants_of_file(f['id'])
                ids = sql.get_samples_of_file(f['id'])
            except:
                print f['filename']
                print line
                raise

            for id in ids:
                if int(line_plant_id) == int(id):
                    count += 1

        print '%s: %d (%d)' % ( f['filename'], count, len(lines) )
            #        print f['filename']
            #        print line
            #        break
            #else: # nice hack to break out of two loops
            #    continue
            #break


if __name__ == '__main__': main(sys.argv[1:])
