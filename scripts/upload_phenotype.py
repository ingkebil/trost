#!usr/bin/python2
# .. module:: upload_phenotype
#    :synopsys: Convert xlsx to csv and then upload that file to the TROST website.
# .. moduleauthor:: Kenny Billiau <billiau@mpimp-golm.mpg.de>

import sys
import urllib2
from poster.encode import multipart_encode
from poster.streaminghttp import register_openers

for file_name in sys.argv[1:]:
    print "%s\n" % (file_name)

    # upload the CSV
    register_openers()
    datagen, headers = multipart_encode({
        '_method':'POST',
        'data[Culture][experiment_id]':1, 
        'data[Plant][culture_id]':1,
        'data[Phenotype][program_id]':0,
        'data[File][raw]': open(file_name, 'rb'),
        'data[File][manual]': 0
    })

    #req = urllib2.Request("http://trost.mpimp-golm.mpg.de/de-de/phenotypes/upload", datagen, headers)
    req = urllib2.Request("http://localhost/trost/de-de/phenotypes/upload", datagen, headers)
    print >> sys.stderr, urllib2.urlopen(req).read()

    # maybe delete the tmp_file?
    # 

# http://atlee.ca/software/poster/
