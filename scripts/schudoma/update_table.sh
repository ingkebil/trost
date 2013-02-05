table=$1
data_dir=~/svn/trost/trunk/data/backups
backup_file=$data_dir/trost_prod_`date +%F_%X`.sql.gz
plants_file=$data_dir/${table}_`date +%F_%X`.sql

database=trost_prod
server=cosmos


# get the previous $table file
prev_plants_file=(`ls -t $data_dir/${table}_*`)
prev_plants_file=$prev_plants_file[1]
echo "Found old $table: $prev_plants_file"

# generate the new plants
echo -n "Generating new $table ..."
echo "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;" > $plants_file
python update_$table.py >> $plants_file
echo "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;" >> $plants_file
echo "done: $plants_file"

# compare new plants with old plants
diff=`diff -q $prev_plants_file $plants_file`
if [[ $? -eq 0 || $? -eq 1 ]]; then
    if [[ -n $diff ]]; then
        echo -n "Making backup ..."
        mysqldump -u backup -ppasswordpassw -h $server --default-character-set=latin1 --skip-set-charset $database | pigz -9 > $backup_file
        echo "done."
        echo -n "Updating $table ..."
        mysql -u billiau -ppassword -h $server $database < $plants_file
        echo "done."
    else
        echo -n "No changes found, removing $plants_file ..."
        `rm $plants_file`
        echo "done."
    fi
else
    echo "ERR: $diff"
fi
