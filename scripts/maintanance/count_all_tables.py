#!/usr/bin/env python

import sql
import sys

def main(argv): 
    tables = sql.get_tables()

    for table in tables:
        print "%s: %d" % (table, sql.count(table))

if __name__ == '__main__': main(sys.argv[1:])
