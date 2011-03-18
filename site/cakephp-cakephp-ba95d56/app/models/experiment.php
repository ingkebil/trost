<?php
class Experiment extends AppModel {
	var $name = 'Experiment';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Culture' => array(
			'className' => 'Culture',
			'foreignKey' => 'experiment_id',
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