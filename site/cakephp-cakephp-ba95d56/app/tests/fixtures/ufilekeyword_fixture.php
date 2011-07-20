<?php
/* Ufilekeyword Fixture generated on: 2011-07-19 11:38:56 : 1311068336 */
class UfilekeywordFixture extends CakeTestFixture {
	var $name = 'Ufilekeyword';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ufile_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'keyword_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'files_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'keywords_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_filekeywords_files1' => array('column' => 'files_id', 'unique' => 0), 'fk_filekeywords_keywords1' => array('column' => 'keywords_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'ufile_id' => 1,
			'keyword_id' => 1,
			'files_id' => 1,
			'keywords_id' => 1
		),
	);
}
?>