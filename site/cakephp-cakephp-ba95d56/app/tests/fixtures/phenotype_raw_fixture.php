<?php
/* PhenotypeRaw Fixture generated on: 2011-03-22 17:23:34 : 1300811014 */
class PhenotypeRawFixture extends CakeTestFixture {
	var $name = 'PhenotypeRaw';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'phenotype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'raw_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'line_nr' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotype_raws_phenotypes1' => array('column' => 'phenotype_id', 'unique' => 0), 'fk_phenotype_raws_raws1' => array('column' => 'raw_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'phenotype_id' => 1,
			'raw_id' => 1,
			'line_nr' => 1
		),
	);
}
?>