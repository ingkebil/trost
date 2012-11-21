data_dir=~/svn/trost/trunk/data
backup_file=$data_dir/backups/trost_prod_`date +%F`.sql
plants_file=$data_dir/backups/plants_`date +%F`.sql

echo -n "Making backup ..."
mysqldump -u backup -ppasswordpassw -h cosmos --default-character-set=latin1 --skip-set-charset trost_prod > $backup_file
echo "done."
echo -n "Generating new plants ..."
echo "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;" > $plants_file
python update_plants.py >> $plants_file
echo "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;" >> $plants_file
echo "done."
echo -n "Updating plants ..."
mysql -u billiau -ppassword -h cosmos trost_prod < $plants_file
echo "done."
