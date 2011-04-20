<?php
class Sample extends AppModel {

	var $name = 'Sample';

	var $hasMany = array(
		'Plant' => array(
			'className' => 'Plant',
			'foreignKey' => 'sample_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>
