<?php
/* PhenotypeEntity Fixture generated on: 2011-03-22 17:23:16 : 1300810996 */
class PhenotypeEntityFixture extends CakeTestFixture {
	var $name = 'PhenotypeEntity';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'phenotype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'entity_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotype_entities_phenotypes1' => array('column' => 'phenotype_id', 'unique' => 0), 'fk_phenotype_entities_entities1' => array('column' => 'entity_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'phenotype_id' => 1,
			'entity_id' => 1
		),
	);
}
?>