<?php
class ufilekeyword extends AppModel {
	var $name = 'ufilekeyword';
	var $validate = array(
		'ufile_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'keyword_id' => array(
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
		'Ufile' => array(
			'className' => 'Ufile',
			'foreignKey' => 'ufile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Keyword' => array(
			'className' => 'Keyword',
			'foreignKey' => 'keyword_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>