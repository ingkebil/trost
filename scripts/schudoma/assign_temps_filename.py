#!/usr/bin/python

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
    args = parser.parse_args(argv)
    
    for full_fn in args.files:
        fn = ntpath.basename(full_fn)
        # look up the file id
        file_id  = sql.fetch('ufiles', fn, id_key='name')
        if not file_id:
            print "File %s not found, skipping" % fn
        else:
            page = 0
            data = []
            headers = []
            try:
                data, headers = p_xls.read_xls_data(full_fn, page)
            except IndexError:
                pass
            else:
                page += 1 
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
                if rs != False and len(rs) == 1:
                    sql.insert('ufiletemps', {
                        'ufile_id': file_id['id'],
                        'temp_id':  rs[0]['id']
                    })
            sql.commit()
    return None

if __name__ == '__main__': main(sys.argv[1:])
