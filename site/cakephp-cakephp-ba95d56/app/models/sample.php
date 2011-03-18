<?php
class Sample extends AppModel {
	var $name = 'Sample';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

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