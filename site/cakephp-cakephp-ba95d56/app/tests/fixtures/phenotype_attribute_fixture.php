<?php
/* PhenotypeAttribute Fixture generated on: 2011-03-18 17:11:18 : 1300464678 */
class PhenotypeAttributeFixture extends CakeTestFixture {
	var $name = 'PhenotypeAttribute';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'phenotype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotype_attributes_attributes1' => array('column' => 'attribute_id', 'unique' => 0), 'fk_phenotype_attributes_phenotypes1' => array('column' => 'phenotype_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'attribute_id' => 1,
			'phenotype_id' => 1,
			'value' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>