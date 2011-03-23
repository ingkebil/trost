<?php
/* PhenotypeValue Fixture generated on: 2011-03-22 17:23:37 : 1300811017 */
class PhenotypeValueFixture extends CakeTestFixture {
	var $name = 'PhenotypeValue';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'value_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'phenotype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'number' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotype_attributes_phenotypes1' => array('column' => 'phenotype_id', 'unique' => 0), 'fk_phenotype_values_values1' => array('column' => 'value_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'value_id' => 1,
			'phenotype_id' => 1,
			'number' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>