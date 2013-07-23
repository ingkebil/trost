#!/usr/bin/python
# -*- coding: utf8 -*-

import sys
import argparse
import ntpath

import sql
import process_xls as p_xls

###
def main(argv):

    parser = argparse.ArgumentParser(description='')
    parser.add_argument('files', nargs='+')
    parser.add_argument('--standortid', type=int)
    parser.add_argument('--pages', type=int, default=1)
    args = parser.parse_args(argv)
    
    for full_fn in args.files:
        fn = ntpath.basename(full_fn)
        # look up the file id
        file_id  = sql.fetch('ufiles', fn, id_key='name')
        if not file_id:
            print "File '%s' not found in DB, skipping" % fn
        else:
            data = []
            headers = []
            for page in xrange(args.pages):
                data, headers = p_xls.read_xls_data(full_fn, page)
                lines = 0 # administration: number of succesfully inserted lines
                for row in data:
                    standortid = -1
                    if hasattr(row, 'StandortID'):
                        standortid = getattr(row, 'StandortID')
                    elif args.standortid != None:
                        standortid = args.standortid
                    else:
                       sys.stderr.write('No StandortID found!')
                       exit()

                    rs = sql.fetch_all('temps', {
                        'datum': getattr(row, 'Datum'),
                        'location_id': standortid
                    })
                    if rs != False:# and len(rs) == 1:
                        for i in xrange(len(rs)):
                            if (sql.insert('ufiletemps', {
                                'ufile_id': file_id['id'],
                                'temp_id':  rs[i]['id']
                            })):
                                lines += 1
                            else:
                                print "%d,%d" % (file_id['id'], rs[i]['id'])
                print "Inserted %d/%d of page %d" % (lines, len(data), page)
            sql.commit() # after each file

    return None

if __name__ == '__main__': main(sys.argv[1:])
