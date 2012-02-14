#!/usr/bin/python

import sys

import sql
import ora_sql

###
def main(argv):
    trost_plants = sql.get_plants() # aliquot_id: PK id
    trost_subspecies = sql.get_subspecies() # subspecies: PK id
 
    bad_plants = []

    for aliquot_id, plant_id in trost_plants.iteritems():
        subspecies_id = ora_sql.get_subspecies_id(aliquot_id)
        if (trost_subspecies.has_key(subspecies_id)):
            print "UPDATE `plants` SET subspecies_id = %d WHERE id = %d;" % (trost_subspecies[subspecies_id], plant_id)
        else:
            bad_plants.append(plant_id)

    if len(bad_plants) > 0:
        print len(bad_plants)

    return None

if __name__ == '__main__': main(sys.argv[1:])
