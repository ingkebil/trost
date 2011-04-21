<?php
class PhenotypeValue extends AppModel {
	var $name = 'PhenotypeValue';
	var $validate = array(
		'value_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a value',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'phenotype_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a phenotype',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Value' => array(
			'className' => 'Value',
			'foreignKey' => 'value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Phenotype' => array(
			'className' => 'Phenotype',
			'foreignKey' => 'phenotype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
