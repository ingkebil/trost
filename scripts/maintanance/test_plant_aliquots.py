#!/usr/bin/python

import sys
import login

def main(argv):
    c = login.get_db().cursor()
    c.execute("select distinct plants.id from plants left join live_plants on live_plants.id = plants.id left join dead_plants on dead_plants.id = plants.id where live_plants.id is NULL and dead_plants.id is null")
    poss_aliquots = c.fetchall()

    c = login.get_db().cursor()
    c.execute("select id from aliquots")
    aliquots = c.fetchall()
    aliquots = dict( # make the resultset into a dictionary: aliquot_id => whatever
        zip(
            map(lambda x: x[0], aliquots), # the resultset aliquots are one element tuples, so get that one element
            xrange(
                len(aliquots) # give me a meaningless list
            )
        )
    )

    cnt = 0 # the amount of poss_aliquots that is an aliquot
    for poss_aliquot in poss_aliquots:
        if aliquots.has_key(poss_aliquot):
            cnt += 1

    print "%d/%d" % (cnt, len(poss_aliquots))

if __name__ == '__main__': main(sys.argv[1:])
