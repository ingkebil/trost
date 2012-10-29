<?php
class Sample extends AppModel {
	var $name = 'Sample';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'SamplePlant' => array(
			'className' => 'SamplePlant',
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


	var $hasAndBelongsToMany = array(
		'Phenotype' => array(
			'className' => 'Phenotype',
			'joinTable' => 'phenotype_samples',
			'foreignKey' => 'sample_id',
			'associationForeignKey' => 'phenotype_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Plant' => array(
			'className' => 'Plant',
			'joinTable' => 'sample_plants',
			'foreignKey' => 'sample_id',
			'associationForeignKey' => 'plant_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
	);

}
?>
