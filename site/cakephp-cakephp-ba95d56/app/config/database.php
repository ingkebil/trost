<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'trost',
		'password' => 'passwordpas',
		'database' => 'trost_test_prod',
		'encoding' => 'utf8_general_ci'
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
        'prefix' => 'TROST_'
	);
}
?>
