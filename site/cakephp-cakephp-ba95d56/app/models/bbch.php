<?php
class Bbch extends AppModel {
	var $name = 'Bbch';
	var $validate = array(
		'species_id' => array(
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
		'Species' => array(
			'className' => 'Species',
			'foreignKey' => 'species_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Phenotype' => array(
			'className' => 'Phenotype',
			'joinTable' => 'phenotype_bbches',
			'foreignKey' => 'bbch_id',
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
		)
	);

}
?>