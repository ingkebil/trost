<?php
/* PhenotypeBbch Fixture generated on: 2011-03-22 17:23:13 : 1300810993 */
class PhenotypeBbchFixture extends CakeTestFixture {
	var $name = 'PhenotypeBbch';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'phenotype_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'bbch_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_phenotype_bbchs_phenotypes1' => array('column' => 'phenotype_id', 'unique' => 0), 'fk_phenotype_bbchs_bbchs1' => array('column' => 'bbch_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'phenotype_id' => 1,
			'bbch_id' => 1
		),
	);
}
?>