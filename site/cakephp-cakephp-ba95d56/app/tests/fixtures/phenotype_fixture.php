<?php
/* Phenotype Fixture generated on: 2011-03-18 17:11:39 : 1300464699 */
class PhenotypeFixture extends CakeTestFixture {
	var $name = 'Phenotype';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'version' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'object' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'program_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'time' => array('type' => 'time', 'null' => true, 'default' => NULL),
		'plant_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotypes_plants1' => array('column' => 'plant_id', 'unique' => 0), 'fk_phenotypes_programs1' => array('column' => 'program_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'version' => 'Lorem ipsum dolor sit amet',
			'object' => 'Lorem ipsum dolor sit amet',
			'program_id' => 1,
			'date' => '2011-03-18',
			'time' => '17:11:39',
			'plant_id' => 1
		),
	);
}
?>