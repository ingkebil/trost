#!/usr/bin/env bash

# dirs
wd=~/svn/trost/trunk
script_dir=$wd/scripts/schudoma
data_dir=$wd/data/reupload

# db data
db_user=trost_prod
db_pass=passwordpa
db_host=cosmos
db_name=trost_prod

#db_user=root
#db_pass=password
#db_host=localhost
#db_name=trost_prod

db_upload () {
    echo $1
    mysql -u $db_user -p$db_pass -h $db_host $db_name < $1
}

# create the DB
echo "Creating db ... "
db_upload $data_dir/trost_prod.sql
echo "done."

# bbches depends on species, load this first
echo "Logistics ... "
db_upload $data_dir/120816/programs.sql
db_upload $data_dir/120816/species.sql
db_upload $data_dir/120816/experiments.sql
echo "done."

# EAV-model
echo "EAV model ... "
db_upload $data_dir/120816/bbches.sql
db_upload $data_dir/120816/entities.sql
db_upload $data_dir/120816/values.sql
echo "done."

# personel
echo "Personel ... "
python $script_dir/create_locationstable.py $data_dir/120815/locations_with_geodata.xls > $data_dir/120815/locations.sql
db_upload $data_dir/120815/locations.sql
db_upload $data_dir/120816/people.sql
echo "done."

# file upload - depends on people.sql
echo "File uploade ... "
db_upload $data_dir/120816/keywords.sql
db_upload $data_dir/120816/ufiles.sql
db_upload $data_dir/120816/ufilekeywords.sql
echo "done."

# i18n
echo "i18n ... "
db_upload $data_dir/120816/i18n.sql
echo "done."

# cultures from LIMS and the xls file
echo "cultures ..."
python $script_dir/create_culturetable.py -d $data_dir/120817/culture_data.xls > $data_dir/120817/cultures.sql
db_upload $data_dir/120817/cultures.sql
mv $data_dir/120817/cultures.sql $data_dir/120817/cultures_lims.sql
python $script_dir/create_culturetable.py $data_dir/120817/culture_data.xls > $data_dir/120817/cultures.sql
db_upload $data_dir/120817/cultures.sql
echo "done."

# insert all plants
echo "plants ..."
python $script_dir/update_plants.py > $data_dir/120828/plants.sql
db_upload $data_dir/120828/plants.sql
echo "done."

# insert all subspecies
python $script_dir/create_subspeciestable.py $data_dir/120828/TROSTSorten2012.xls > $data_dir/120828/subspecies.sql
db_upload $data_dir/120828/subspecies.sql

# insert irrigation -- TODO why didn't we upload the Petersgroden file?
python $script_dir/create_irrigationtable.py $data_dir/120829/irrigation/EingabeKlimadaten_Dethlingen.xls $data_dir/120829/irrigation/EingabeKlimadaten_Golm2011.xls > $data_dir/120829/irrigation/irrigation.sql
db_upload $data_dir/120829/irrigation/irrigation.sql

# insert the starch data
python $script_dir/create_starchtable.py $data_dir/120829/starch/*xls > $data_dir/120829/starch/starch.sql
db_upload $data_dir/120829/starch/starch.sql

# insert the treatment data
python $script_dir/create_trmttable.py $data_dir/120831/*xls > $data_dir/120831/treatments.sql
db_upload $data_dir/120831/treatments.sql

# insert temperatures
db_upload $data_dir/120831/temps.sql

# upload all the scanner files
python $script_dir/update_phenotypes.py $data_dir/120907/*

# upload all the scanner files
# had to check these out manually because of a weird entity Id in there. just added a dummy entity: -12345
python $script_dir/update_phenotypes.py $data_dir/120907/problems/*

# it seems I am wasting my time making interfaces no-one uses
python $script_dir/import_climate.py --pages=2 $data_dir/121210/EingabeKlimadaten.xls > $data_dir/121210/temps.sql
db_upload $data_dir/121210/temps.sql

# and here it comes again - also, be aware that this file seems to create three extra NULL entries and will most like fail to import
python $script_dir/import_climate.py $data_dir/130117/EingabeKlimadaten_5543_18_38KW_2012_updated_columns.xls > $data_dir/130117/temps.sql
db_upload $data_dir/130117/temps.sql
python $script_dir/import_climate.py $data_dir/130118/Klimadaten 2012 Schrobenhausen_updated_columns.xls > $data_dir/130118/temps.sql
db_upload $data_dir/130118/temps.sql

python $script_dir/import_climate_leusewitz.py $data_dir/130128/Kopie\ von\ Wetter\ 2012\ \(Köhl\).xls > temps.sql
db_upload $data_dir/130128/temps.sql

python $script_dir/import_climate_boehlendorf.py $data_dir/130128/Boehlendorf/TROST\ Klimadaten\ 2012.xls > temps.sql
db_upload $data_dir/130128/Boehlendorf/temps.sql

python $script_dir/import_climate_LWK.py $data_dir/130128/LWK/LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2012.xls | grep -v NULL,NULL,NULL,NULL,NULL > temps.sql
db_upload $data_dir/130128/LWK/temps.sql

python $script_dir/import_climate.py $data_dir/130129/Kaltenberg/Klimadaten_2012_Kaltenberg.xls > temps.sql
db_upload $data_dir/130129/Kaltenberg/temps.sql

python $script_dir/import_climate.py $data_dir/130129/NORIKA/EingabeKlimadaten_NORIKA_2012.xls > temps.sql
db_upload $data_dir/130129/NORIKA/temps.sql

# assign the climate file to the just inserted climte data
python $script_dir/assign_temps_filename.py $data_dir/130129/Kaltenberg/Klimadaten_2012_Kaltenberg.xls 
python $script_dir/assign_temps_filename.py $data_dir/130129/NORIKA/EingabeKlimadaten_NORIKA_2012.xls
python $script_dir/assign_temps_filename.py $data_dir/130128/LWK/LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2012.xls
python $script_dir/assign_temps_filename.py $data_dir/130128/Boehlendorf/TROST\ Klimadaten\ 2012.xls
python $script_dir/assign_temps_filename.py --standortid=5506 "$data_dir/130128/Kopie von Wetter 2012 (Köhl).xls"
python $script_dir/assign_temps_filename.py $data_dir/130118/Klimadaten\ 2012\ Schrobenhausen_updated_columns.xls
python $script_dir/assign_temps_filename.py $data_dir/130117/EingabeKlimadaten_5543_18_38KW_2012_updated_columns.xls 
python $script_dir/assign_temps_filename.py $data_dir/121210/EingabeKlimadaten.xls
python $script_dir/assign_temps_filename.py $data_dir/130131/EingabeKlimadaten_Golm2011.xls
python $script_dir/assign_temps_filename.py --pages=5 $data_dir/130201/LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2011\ -\ alle\ Monate.xls
python $script_dir/import_climate_unicode.py $data_dir/130205/120912\ EingabeKlimadaten.xls > $data_dir/130205/temps.sql
db_upload $data_dir/130205/temps.sql
python $script_dir/assign_temps_filename.py $data_dir/130205/120912\ EingabeKlimadaten.xls

python $script_dir/update_phenotypes.py $data_dir/130325/*

python $script_dir/import_climate_unicode.py $data_dir/130904/EingabeKlimadaten_Golm2013.xls > temps.sql
db_upload $data_dir/130904/temps.sql

