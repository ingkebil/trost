import sys
#import sql
import login

path = '/home/billiau/cosmos/virtualhosts/trost/html/database/app/webroot/sfiles/'

def main(args):
    db = login.get_db();
    
    # get all the file names and their associated users
    s = """
    select f.name AS filename, f.created as filecreated, p.name as username, p.id as userid
    from ufiles f
    join people p on p.id = f.person_id
    """
    c = db.cursor()
    c.execute(s)
    rs = c.fetchall()
    desc = [d[0] for d in c.description]
    rows = []
    if len(rs) > 0:
        rows = [ dict(zip(desc, row)) for row in rs ]

    for row in rows:
        full_filename = path + row['username'] + str(row['userid']) + '/' + row['filename']
        try:
            with open(full_filename): pass
        except IOError:
            print full_filename




if __name__ == '__main__': main(sys.argv[1:]);
