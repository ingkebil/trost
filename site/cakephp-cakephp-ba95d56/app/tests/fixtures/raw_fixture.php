<?php
/* Raw Fixture generated on: 2011-03-22 17:23:49 : 1300811029 */
class RawFixture extends CakeTestFixture {
	var $name = 'Raw';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'data' => array('type' => 'binary', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'data' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>