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

    select id into @last_msg_id from __logmessages where active = 1 and `user` = USER() order by `date` DESC limit 1;
    if @last_msg_id IS NOT NULL then
        select id into @last_log_id from __log where `user` = user() and `table` = '%(table)s' and `action` = 'insert' and affected_id = NEW.id ORDER BY `date` DESC limit 1;
        insert into __log_logmessages (log_id, msg_id) VALUES (@last_log_id, @last_msg_id);
    end if;
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

    select id into @last_msg_id from __logmessages where active = 1 and `user` = USER() order by `date` DESC limit 1;
    if @last_msg_id IS NOT NULL then
        select id into @last_log_id from __log where `user` = user() and `table` = '%(table)s' and `action` = 'delete' and affected_id = OLD.id ORDER BY `date` DESC LIMIT 1;
        insert into __log_logmessages (log_id, msg_id) VALUES (@last_log_id, @last_msg_id);
    end if;
end //
delimiter ;
"""

update = """
drop trigger if exists %(table)s_update_trigger;
delimiter //
create trigger %(table)s_update_trigger after update on `%(table)s`
for each row
begin
    if (OLD.invalid != NEW.invalid OR (OLD.invalid IS NULL AND NEW.invalid = 1)) THEN
        set @action = 'invalidated';
        if (NEW.invalid = 0 OR NEW.invalid IS NULL) THEN
            set @action = 'validated';
        end if;
        insert into %(log)s (`date`, `user`, `table`, `action`,affected_id)
        values (now(), user(), '%(table)s', @action, OLD.id);

        select id into @last_msg_id from __logmessages where active = 1 and `user` = USER() order by `date` DESC limit 1;
        if @last_msg_id IS NOT NULL then
            select id into @last_log_id from __log where `user` = user() and `table` = '%(table)s' and `action` = @action and affected_id = OLD.id ORDER BY `date` DESC LIMIT 1;
            insert into __log_logmessages (log_id, msg_id) VALUES (@last_log_id, @last_msg_id);
        end if;
    end if;
end //
delimiter ;
"""

log_proc = """
DROP PROCEDURE IF EXISTS `memaybe`;
DELIMITER ;;

CREATE PROCEDURE `memaybe` (IN msg TEXT)
BEGIN
    call menot();
    -- insert new message
    INSERT INTO `__logmessages` (message) VALUES (msg);
END;;

DROP PROCEDURE IF EXISTS `menot`;;
CREATE PROCEDURE `menot` ()
BEGIN
    SELECT count(*) INTO @log_count FROM __logmessages lm
    JOIN __log_logmessages llm on llm.msg_id = lm.id
    WHERE lm.active = 1
    AND `user` = USER();
    if @log_count = 0 then
        DELETE FROM __logmessages WHERE active = 1 AND `user` = USER();
    end if;
    UPDATE `__logmessages` SET active = 0 WHERE active = 1 AND user = USER();
END;;

DROP TRIGGER IF EXISTS `__logmessages_bi`;;
CREATE TRIGGER `__logmessages_bi` BEFORE INSERT ON `__logmessages` FOR EACH ROW SET NEW.user = USER();;

DELIMITER ;
"""

def main(argv):
    # make sure not to add triggers to the logging table
    blacklist = [ LOG_TABLE_NAME, '__logmessages' ]

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

    print log_proc;
    

if __name__ == '__main__':
    main(sys.argv[1:])
