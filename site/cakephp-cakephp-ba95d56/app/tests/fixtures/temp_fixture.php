<?php
/* Temp Fixture generated on: 2011-05-03 17:08:24 : 1304435304 */
class TempFixture extends CakeTestFixture {
	var $name = 'Temp';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'datum' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'rainfall' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'tmin' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'tmax' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'datum' => '1304435304',
			'rainfall' => 1,
			'tmin' => 1,
			'tmax' => 1
		),
	);
}
?>