#!/usr/bin/env bash
#db_name=trost_prod
#db_user=billiau
#db_pass=password
#db_host=cosmos

db_user=root
db_pass=password
db_host=localhost
db_name=trost_prod

TFILE="/tmp/$(basename $0).$$.tmp"

echo 'SET foreign_key_checks = 0;' > $TFILE
echo 'SELECT Concat("TRUNCATE TABLE `", TABLE_NAME, "`;") FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA="trost_prod";' | mysql -u $db_user -h $db_host -p$db_pass --skip-column-names $db_name >> $TFILE
echo 'SET foreign_key_checks = 1;' >> $TFILE

mysql -u $db_user -p$db_pass -h $db_host $db_name < $TFILE
rm $TFILE
