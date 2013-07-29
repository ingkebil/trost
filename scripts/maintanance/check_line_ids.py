#!/usr/bin/python
# -*- coding: utf8 -*-

import sys
import login

# short script to test if some line ids where succesfully imported into phenotyper


line_ids = {
    899448:1,
    899787:1,
    899463:1,
    899803:1,
    899837:1,
    899838:1,
    899839:1,
    899878:1,
    899880:1,
    899909:1,
    899923:1,
    899930:1,
    899939:1,
    899942:1,
    899943:1,
    899945:1,
    899951:1,
    899954:1,
    899955:1,
    899959:1,
    899965:1,
    899966:1,
    899979:1,
    899988:1,
    900004:1,
    900021:1,
    900022:1,
    900035:1,
    900036:1,
    900040:1,
    899481:1,
    899468:1,
    899474:1,
    899484:1,
    899485:1,
    899487:1,
    899503:1,
    899508:1,
    899520:1,
    899522:1,
    899523:1,
    899526:1,
    899528:1,
    899533:1,
    899534:1,
    899540:1,
    899541:1,
    899542:1,
    899544:1,
    899546:1,
    899547:1,
    899548:1,
    899556:1,
    899557:1,
    899570:1,
    899571:1,
    899577:1,
    899578:1,
    899582:1,
    899590:1,
    899594:1,
    899624:1,
    899630:1,
    899631:1,
    899639:1,
    899642:1,
    899652:1,
    899666:1,
    899691:1,
    899695:1,
    899700:1,
    899707:1,
    899736:1,
    899737:1,
    899738:1,
    899615:1
}

def main(argv):
    db = login.get_db()
    c = db.cursor()
    c.execute("SELECT id from plantlines order by id")
    rs = c.fetchall()
    lims_line_ids = dict((row[0], 1) for row in rs)
    for line_id in line_ids.keys():
        #if not line_ids.has_key(row[0]):
        #    print "%s has no lims line id!" % row[0]
        if not lims_line_ids.has_key(line_id):
            print line_id

if __name__ == '__main__': main(sys.argv[1:])
