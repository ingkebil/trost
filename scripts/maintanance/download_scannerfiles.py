#!/usr/bin/env python

import sys
import sql

def main(argv):
    raws = sql.get_raws()

    for filename, contents in raws.iteritems():
        fn = open('%s/%s' % (argv[0], filename), 'w')
        fn.write(contents)
        fn.flush()
        fn.close()

if __name__ == '__main__': main(sys.argv[1:])
