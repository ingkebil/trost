<?php
class DATABASE_CONFIG {

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'trost',
		'password' => 'passwordpas',
		'database' => 'trost',
		'encoding' => 'utf8_general_ci'
	);

    var $lims = array(
		'driver' => 'oracle',
        #'connect' => 'oci_connect',
		'persistent' => false,
		'host' => 'limstest',
        'port' => '1521',
		'login' => 'TROST_USER',
		'password' => 'passwordp',
		'database' => 'naut81',
		'encoding' => 'utf8_general_ci',
        'prefex' => 'TROST_'
	);
}
?>
