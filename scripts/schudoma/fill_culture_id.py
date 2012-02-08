#!/usr/bin/python

import os
import sys

import sql
import ora_sql
import data_objects 

###
def main(argv):
    trost_cultures = sql.get_cultures()
    trost_plants   = sql.get_plants()

    trost_bad_plants = []
    trost_good_plants = []

    for culture_id in trost_cultures:
        lims_plants = ora_sql.get_aliquots(culture_id)
        for lims_plant in lims_plants:
            if (trost_plants.has_key(lims_plant)):
                trost_good_plants.append(data_objects.plant(
                    plant_id=lims_plant,
                    trost_plant_id=trost_plants[lims_plant],
                    culture_id=culture_id,
                    trost_culture_id=trost_cultures[culture_id]
                ))
            else:
                trost_bad_plants.append(data_objects.plant(
                    plant_id=lims_plant,
                    trost_plant_id=trost_plants[lims_plant],
                    culture_id=culture_id,
                    trost_culture_id=trost_cultures[culture_id]
                ))
    
    print trost_good_plants
    print trost_good_plants

    return None

if __name__ == '__main__': main(sys.argv[1:])
