<?php
class DATABASE_CONFIG {

    # production database
	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'gent',
		'login' => 'trost',
		'password' => 'passwordpas',
		'database' => 'trost',
		'encoding' => 'utf8_general_ci'
	);

    ## alternative after prod db went down
	#var $default = array(
	#	'driver' => 'mysql',
	#	'persistent' => false,
	#	'host' => 'gent',
	#	'login' => 'trost',
    #    'password' => 'passwordpas',
	#	'database' => 'db_billiau_trost',
	#	'encoding' => 'utf8_general_ci'
	#);

    # only following params are taken into account: database, connect, driver, login, password and prefix
    var $lims_aliquot = array(
		'driver' => 'oracle',
        'connect' => 'oci_connect',
		'persistent' => false,
		'host' => 'limsdb.mpimp-golm.mpg.de',
        'port' => '1521',
		'login' => 'lims_read',
		'password' => 'passwo',
		#'database' => 'limstest/naut81',
        'database' => '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=141.14.247.123)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = naut81.mpimp-golm)))',
        'schema' => 'lims',
		#'encoding' => 'utf8',
        #'prefix' => 'TROST_',
	    #'charset' => 'utf8'
	);

    # only following params are taken into account: database, connect, driver, login, password and prefix
    var $lims = array(
		'driver' => 'oracle',
        'connect' => 'oci_connect',
		'persistent' => false,
		'host' => 'limstest.mpimp-golm.mpg.de',
        'port' => '1521',
		'login' => 'TROST_USER',
		'password' => 'passwordp',
		#'database' => 'limstest/naut81',
        'database' => '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=141.14.247.122)(PORT=1521)) (CONNECT_DATA=(SERVER=DEDICATED) (SERVICE_NAME = naut81.mpimp-golm)))',
        'schema' => 'lims',
		#'encoding' => 'utf8',
        'prefix' => 'TROST_',
	    #'charset' => 'utf8'
	);
}
?>
