<?php
class Subspecies extends AppModel {
	var $name = 'Subspecies';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Species' => array(
			'className' => 'Species',
			'foreignKey' => 'species_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Plant' => array(
			'className' => 'Plant',
			'foreignKey' => 'subspecies_id',
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