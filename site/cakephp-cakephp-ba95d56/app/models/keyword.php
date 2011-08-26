<?php
class Keyword extends AppModel {
	var $name = 'Keyword';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'Please enter a username' => array(
                'rule' => array('isUnique'),
            ),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Ufilekeyword' => array(
			'className' => 'Ufilekeyword',
			'foreignKey' => 'keyword_id',
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
        'Ufile' => array(
            'className' => 'Ufile',
            'joinTable' => 'ufilekeywords',
            'foreignKey' => 'keyword_id',
            'associationForeignKey' => 'ufile_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''),
    );

    var $actsAs = array('Translate' => 'name');

}
?>
