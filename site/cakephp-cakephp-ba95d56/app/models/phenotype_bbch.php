<?php
class PhenotypeBbch extends AppModel {
	var $name = 'PhenotypeBbch';
	var $validate = array(
		'phenotype_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bbch_id' => array(
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
		'Phenotype' => array(
			'className' => 'Phenotype',
			'foreignKey' => 'phenotype_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Bbch' => array(
			'className' => 'Bbch',
			'foreignKey' => 'bbch_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    var $actsAs = array('Containable');
}
?>
