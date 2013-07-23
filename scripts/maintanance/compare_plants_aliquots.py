#!/usr/bin/env python

import sys
import sql

def main(argv):
    aliquots = sql.fetch_all('aliquots', { '1': '1'})
    print "Found %d aliquots ..." % len(aliquots)
    for aliquot in aliquots:
        aliquot_id = aliquot['id']
        sys.stdout.write("Checking %d ...\r" % aliquot_id)
        a_plants  = sql.fetch_all('aliquot_plants',  { 'aliquot_id': aliquot_id })
        a_samples = sql.fetch_all('aliquot_samples', { 'aliquot_id': aliquot_id })

        if len(a_plants) > 0 and len(a_samples) == 0:
            print "%d has plants but no samples!" % aliquot_id
            # cannot be as an aliquot comes from a sample that comes from a plant
        if len(a_plants) == 0 and len(a_samples) > 0:
            print "%d has samples but no plants !" % aliquot_id
            # cannot be as a sample must come from a plant
        for a_sample in a_samples:
            a_sample_id = a_sample['sample_id']
            s_plants = sql.fetch_all('sample_plants', { 'sample_id': a_sample_id })
            # be iterating over the aliquot's plants, we make sure that we check that the aliquot's samples exist
            for a_plant in a_plants:
                found = False
                for s_plant in s_plants:
                    if a_plant['plant_id'] == s_plant['plant_id']:
                        found = True
                if not found:
                    print "%d (%d) not found with %d" % (a_plant['plant_id'], aliquot_id, a_sample_id)


if __name__ == '__main__':
    main(sys.argv[1:])
