#!/usr/bin/env python

import sys
import sql


LOG_TABLE_NAME = '__log'

insert = """
drop trigger if exists %(table)s_insert_trigger;
delimiter //
create trigger %(table)s_insert_trigger after insert on `%(table)s`
for each row
begin
    insert into %(log)s (`date`, `user`, `table`, `action`, affected_id)
    values (now(), user(), '%(table)s', 'insert', NEW.id);
end //
delimiter ;
"""

delete = """
drop trigger if exists %(table)s_delete_trigger;
delimiter //
create trigger %(table)s_delete_trigger after delete on `%(table)s`
for each row
begin
    insert into %(log)s (`date`, `user`, `table`, `action`,affected_id)
    values (now(), user(), '%(table)s', 'delete', OLD.id);
end //
delimiter ;
"""


def main(argv):
    # get all tables from the DB
    tables = sql.get_tables()

    # TODO automate this: all tables without a PK 'id' should be blacklisted as the triggers rely on this column
    blacklist = [ LOG_TABLE_NAME, 'aliquot_plants', 'aliquot_samples', 'pw_codes', 'sample_plants', 'shirt', 'ufiletemps' ]


    # add two triggers to each table
    for table in tables:
        if table in blacklist: continue
        print insert % { 'table': table, 'log': LOG_TABLE_NAME }
        print delete % { 'table': table, 'log': LOG_TABLE_NAME }

if __name__ == '__main__':
    main(sys.argv[1:])
