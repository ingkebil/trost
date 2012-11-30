data_dir=~/svn/trost/trunk/data
backup_file=$data_dir/backups/trost_prod_`date +"%F_%X"`.sql.gz
aliquots_file=$data_dir/backups/aliquots_`date +"%F_%X"`.sql

echo -n "Making backup ..."
mysqldump -u backup -ppasswordpassw -h cosmos --default-character-set=latin1 --skip-set-charset trost_prod | pigz -9 > $backup_file
echo "done."
echo -n "Generating new aliquots ..."
echo "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;" > $aliquots_file
python update_aliquots.py >> $aliquots_file
echo "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;" >> $aliquots_file
echo "done."
echo -n "Updating aliquots ..."
mysql -u billiau -ppassword -h cosmos trost_prod < $aliquots_file
echo "done."
