<?php
class ufile extends AppModel {

	var $name = 'ufile';
	var $validate = array(
		#'submitter' => array(
		#	'notempty' => array(
		#		'rule' => array('notempty'),
		#		//'message' => 'Your custom message here',
		#		//'allowEmpty' => false,
		#		//'required' => false,
		#		//'last' => false, // Stop validation after this rule
		#		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		#	),
		#),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	#var $hasMany = array(
	#	'Ufilekeyword' => array(
	#		'className' => 'Ufilekeyword',
	#		'foreignKey' => 'ufile_id',
	#		'dependent' => false,
	#		'conditions' => '',
	#		'fields' => '',
	#		'order' => '',
	#		'limit' => '',
	#		'offset' => '',
	#		'exclusive' => '',
	#		'finderQuery' => '',
	#		'counterQuery' => ''
	#	)
	#);

    var $hasAndBelongsToMany = array(
        'Keyword' => array(
            'className' => 'Keyword',
            'joinTable' => 'ufilekeywords',
            'foreignKey' => 'ufile_id',
            'associationForeignKey' => 'keyword_id',
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

    var $belongsTo = array('Person');

    var $actsAs = array('Containable');

    function find_duplicates() {
        $q = "select * from ufiles UFile
            join (select id, name from ufiles where invalid is NULL or invalid = 0) as f2
            where UFile.name = f2.name
            and UFile.id > f2.id
            and (UFile.invalid is NULL or UFile.invalid = 0)";
        return $this->query($q);
    }

}
?>
