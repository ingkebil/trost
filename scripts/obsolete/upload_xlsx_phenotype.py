#!usr/bin/python2
# .. module:: upload_phenotype
#    :synopsys: Convert xlsx to csv and then upload that file to the TROST website.
# .. moduleauthor:: Kenny Billiau <billiau@mpimp-golm.mpg.de>

import sys
import urllib2
from tempfile import mkstemp
from xlsx2csv import xlsx2csv
from poster.encode import multipart_encode
from poster.streaminghttp import register_openers

for file_name in sys.argv[1:]:
    print "%s\n"% (file_name)

    # create the CSV file
    kwargs = {
      'sheetid' : 1,
      'delimiter' : "\t",
      'sheetdelimiter' : '--------',
      'dateformat' : '',
      'skip_empty_lines' : False,
    }
    n, tmp_file_name = mkstemp() # returns a tuple of the file descriptor and the file name
    tmp_file = open(tmp_file_name, 'w+');
    xlsx2csv(file_name, tmp_file, **kwargs)
    tmp_file.close()

    # upload the CSV
    register_openers()
    datagen, headers = multipart_encode({
        '_method':'POST',
        'data[Culture][experiment_id]':1, 
        'data[Plant][culture_id]':1,
        'data[Phenotype][program_id]':0,
        'data[File][raw]': open(tmp_file_name, 'rb'),
        'data[File][manual]': 0
    })

    #req = urllib2.Request("http://trost.mpimp-golm.mpg.de/de-de/phenotypes/upload", datagen, headers)
    req = urllib2.Request("http://localhost/trost/de-de/phenotypes/upload", datagen, headers)
    print urllib2.urlopen(req).read()

    # maybe delete the tmp_file?
    # 

# http://atlee.ca/software/poster/
