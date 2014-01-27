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

update = """
drop trigger if exists %(table)s_update_trigger;
delimiter //
create trigger %(table)s_update_trigger after update on `%(table)s`
for each row
begin
    if OLD.invalid != NEW.invalid THEN
        set @action = 'invalidated';
        if (NEW.invalid = 0 OR NEW.invalid IS NULL) THEN
            set @action = 'validated';
        end if;
        insert into %(log)s (`date`, `user`, `table`, `action`,affected_id)
        values (now(), user(), '%(table)s', @action, OLD.id);
    end if;
end //
delimiter ;
"""

def main(argv):
    # make sure not to add triggers to the logging table
    blacklist = [ LOG_TABLE_NAME ]

    # get all tables from the DB that contain an 'id' column, as we are going to monitor that.
    tables = sql.get_tables_with_column('id')

    # add two triggers to each table
    for table in tables:
        if table in blacklist: continue
        print insert % { 'table': table, 'log': LOG_TABLE_NAME }
        print delete % { 'table': table, 'log': LOG_TABLE_NAME }

    # get all tables with 'invalid' column name and add an update trigger to those
    invalid_tables = sql.get_tables_with_column('invalid')
    for table in invalid_tables:
        if table in blacklist: continue
        print update % { 'table': table, 'log': LOG_TABLE_NAME }

if __name__ == '__main__':
    main(sys.argv[1:])
