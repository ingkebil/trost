<?php
class Plant extends AppModel {
	var $name = 'Plant';
	var $validate = array(
		'culture_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Culture' => array(
			'className' => 'Culture',
			'foreignKey' => 'culture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subspecies' => array(
			'className' => 'Subspecies',
			'foreignKey' => 'subspecies_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Phenotype' => array(
			'className' => 'Phenotype',
			'joinTable' => 'phenotype_plants',
			'foreignKey' => 'plant_id',
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
		'Sample' => array(
			'className' => 'Sample',
			'joinTable' => 'sample_plants',
			'foreignKey' => 'plant_id',
			'associationForeignKey' => 'sample_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>