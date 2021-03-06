#!/usr/bin/env bash

# dirs
wd=~/svn/trost/trunk
script_dir=$wd/scripts/update
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

python $script_dir/upload/update_phenotypes.py $data_dir/130930/*

python $script_dir/maintanance/update_phenotypes.py $data_dir/130930/update/*
# did not test the next statement. Needed because in trost_2012_06_05_3.TXT has a an entry corrected to NULL
echo "UPDATE phenotypes p JOIN phenotype_plants pp where pp.phenotype_id = p.id SET p.entity_id = 810 WHERE pp.plant_id = 1166737 and p.entity_id = -12345;" | mysql -u $db_user -p$db_pass -h $db_host $db_name

python $script_dir/update/import_climate_unicode.py --pages=5 $data_dir/131112/LWK\ NDS\ -\ TROST\ Klimadaten\ 2013.xls > $data_dir/131112/temps.sql
db_upload $data_dir/131112/temps.sql

python $script_dir/update/import_climate_unicode.py --pages=2 $data_dir/131120/Klimadaten_Erntedaten_JKI-RS.xls > $data_dir/131120/temps.sql
db_upload $data_dir/131120/temps.sql

# needed to remove a file and entries that had absolute dryweight but were meant to be absolute freshweight.
echo "delete pr, p, ps from phenotype_raws pr join phenotypes p on p.id = pr.phenotype_id join phenotype_samples ps on ps.phenotype_id = p.id join raws r on r.id = ps.raw_id where r.filename = 'trost_280711_7.txt'" | mysql -u $db_user -p$db_pass -h $db_host $db_name
# added the right file this time
python update_phenotypes.py $data_dir/131210/trost_2011_07_28_6.txt

python $script_dir/import_climate_unicode.py $data_dir/140117/EingabeKlimadaten_Golm2012.xls > $data_dir/140117/temps.sql
db_upload $data_dir/140117/temps.sql

python $script_dir/import_precipitation.py $data_dir/140120/Klimadaten_Erntedaten_JKI-RS_vollstaendig.xls > $data_dir/140120/precipitation_JKI.sql
db_upload $data_dir/140117/precipitation_JKI.sql

python $script_dir/../maintanance/add_triggers.py > $data_dir/140120/triggers.sql
db_upload $data_dir/140120/triggers.sql



python ../../../../scripts/upload/import_irrigation_golm.py $data_dir/140122/4537\ Golm/*_columns.xls > irrigation_golm.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/4537\ Golm/*_columns.xls > precipitation_golm.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/4537\ Golm/*_columns.xls > temperatures_golm.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5540\ Kaltenberg/*.xls > precipitation_kaltenberg.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5540\ Kaltenberg/*.xls > temperatures_kaltenberg.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5541\ Böhlendorf/EingabeKlimadaten_Böhlendorf.xls > precipitation_boehlendorf.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5541\ Böhlendorf/EingabeKlimadaten_Böhlendorf.xls > temperatures_boehlendorf.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5542\ Norika/EingabeKlimadaten_NORIKA.xls > precipitation_norika.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5542\ Norika/EingabeKlimadaten_NORIKA.xls > temperatures_norika.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5543\ Petersgroden/EingabeKlimadaten_Petersgroden.xls > precipitation_petersgroden.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5543\ Petersgroden/EingabeKlimadaten_Petersgroden.xls > temperatures_petersgroden.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5545\ Windeby/EingabeKlimadaten_Windeby.xls > precipidation_windeby.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5545\ Windeby/EingabeKlimadaten_Windeby.xls > temperatures_windeby.sql
python ../../../../scripts/update/import_precipitation.py   $data_dir/140122/5546\ Buetow/EingabeKlimadaten_Bütow.xls > precipitation_buetow.sql
python ../../../../scripts/update/import_climate_unicode.py $data_dir/140122/5546\ Buetow/EingabeKlimadaten_Bütow.xls > temperatures_buetow.sql
python ../../../../scripts/upload/create_irrigationtable.py EingabeKlimadaten_Dethlingen_columns.xls > irrigation_dethlingen.sql

python ../../../../scripts/update/import_precipitation.py EingabeKlimadaten_Kaltenberg_2012.xls > precipitation_akltenberg_2012.sql
python ../../../../scripts/update/import_climate_unicode.py EingabeKlimadaten_Kaltenberg_2012.xls > temperatures_kaltenberg_2012.sql
python ../../../../scripts/update/import_climate_unicode.py EingabeKlimadaten_5543_18_38KW_2012_updated_columns.xls > temp_petersgroden_2012.sql
python ../../../../scripts/update/import_precipitation.py EingabeKlimadaten_5543_18_38KW_2012_updated_columns.xls >prec_ptersgroden_2012.sql
python ../../../../scripts/update/import_precipitation.py  Klimadaten\ 2012\ Schrobenhausen_updated_columns.xls > prec_schorbenhausen_2012.sql
python ../../../../scripts/update/import_precipitation.py  Klimadaten\ 2012\ Schrobenhausen_updated_columns.xls > temps_schorbenhausen_2012.sql
python ../../../../scripts/update/import_climate_unicode.py --standortid=5506 Klimadaten_leusewitz_2012.xls > temps_leusewits_2012.sql
python ../../../../scripts/update/import_precipitation.py --standortid=5506 Klimadaten_leusewitz_2012.xls > prec_leusewitz_2012.sql
python ../../../../scripts/upload/create_irrigationtable.py --pages=5 LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2012.xls > irri_dethlingen_2012.sql
python ../../../../scripts/update/import_precipitation.py --pages=5 LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2012.xls > prec_dethlingen_2012.sql 
python ../../../../scripts/update/import_climate_unicode.py --pages=5 LWK\ NDS\ -\ TROST\ -\ Klimadaten\ 2012.xls > temps_dethlingen_2012.sql
python ../../../../scripts/update/import_climate_unicode.py EingabeKlimadaten_NORIKA_2012.xls > temps_norika_2012.sql
python ../../../../scripts/update/import_precipitation.py EingabeKlimadaten_NORIKA_2012.xls > prec_norika_2012.sql
python ../../../../scripts/update/import_climate_unicode.py --pages=5 LWK\ NDS\ -\ TROST\ Klimadaten\ 2013.xls > temps_dethlingen_2013.sql     
python ../../../../scripts/update/import_precipitation.py --pages=5 LWK\ NDS\ -\ TROST\ Klimadaten\ 2013.xls > prec_dethlingen_2013.sql 
python ../../../../scripts/upload/create_irrigationtable.py --pages=5 LWK\ NDS\ -\ TROST\ Klimadaten\ 2013.xls > irri_dethlingen_2013.sql
python ../../../../scripts/update/import_climate_unicode.py  --standort=5506 Klimadaten_Erntedaten_JKI-RS_vollstaendig.xls > temps_leusewitz_2013.sql
python ../../../../scripts/update/import_precipitation.py Klimadaten_Boehlendorf_2012.xls > prec_boehlendorf_2012.sql
python ../../../../scripts/update/import_precipitation.py --standortid=5506 Klimadaten_Erntedaten_JKI-RS_vollstaendig.xls > prec_leusewitz_2013.sql 

# inserted missing temperatures from the temps table
"insert into temperatures (datum, location_id, tmin, tmax) select temps.datum, temps.location_id, temps.tmin, temps.tmax from temps
left join temperatures t on (t.datum = temps.datum and t.location_id = temps.location_id)
where t.id IS NULL
and (temps.tmin IS NOT NULL OR temps.tmax IS NOT NULL)
and (temps.invalid != 1 OR temps.invalid IS NULL)"

# inserted missing irrigation from the temps table
"insert into irrigation (datum, location_id, amount, treatment_id, culture_id)
select temps.datum, temps.location_id, temps.irrigation, 171, 62328 from temps
    left join irrigation t on (t.datum = temps.datum and t.location_id = temps.location_id)
    where t.id IS NULL
    and temps.irrigation IS NOT NULL
    and temps.irrigation != 0
    and (temps.invalid != 1 OR temps.invalid IS NULL)"

# inserted the missing precipitation from the temps table
"insert into precipitation (datum, location_id, amount)
select temps.datum, temps.location_id, temps.precipitation from temps
    left join precipitation t on (t.datum = temps.datum and t.location_id = temps.location_id)
    where t.id IS NULL
    and temps.precipitation IS NOT NULL
    and temps.precipitation != 0
    and (temps.invalid != 1 OR temps.invalid IS NULL)"

