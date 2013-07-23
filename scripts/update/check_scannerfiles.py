#!/usr/bin/python

import os
import sys
import math
import glob

def check_file(fn):
    
    def is_linetype1(line):
        return line[2] == 'Fast Score' and \
            'freshweight' in line[5] and \
            line[6].strip() == 'mg' and \
            30.0 <= float(line[8]) <= 100.0


    def is_linetype2(line):
        return line[5] == 'component' and \
            line[6].startswith('component')
    
    valid_lines = []
    open_fn = open(fn)
    for line in open_fn:
        if ';' in line:
            sep = ';'
        else:
            sep = '\t'
        line = line.strip().split(sep)
        # print line, fn
        if is_linetype1(line) or is_linetype2(line):
            valid_lines.append(sep.join(line))

    return valid_lines
        
def write_lines(lines, fn, max_lines=1000):
    # print '>>>', fn, 
    fnout = fn.rstrip('.txt').rstrip('.TXT')
    print '>>>', fnout
    p = 0
    f_index = 1
    while p < len(lines):
        fo = open('%s.%02i.lims.txt' % (fnout, f_index), 'w')
        for line in lines[p:p+max_lines]:
            fo.write('%s\n' % line)
        fo.close()
        p += max_lines
        f_index += 1
        pass
    pass


###
def main(argv):

    files = glob.glob('*.txt') + glob.glob('*.TXT')

    for fn in files:
        print fn
        # open('LASTFILE', 'w').write('%s\n' % fn)
        lines = check_file(fn)
        write_lines(lines, fn)

        
        pass
    




    return None

if __name__ == '__main__': main(sys.argv[1:])
