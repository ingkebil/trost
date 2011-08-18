<?php
class Person extends AppModel {
	var $name = 'Person';
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
		),
		'location_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'name' => array(
            'PLease enter your name' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your name',
            ),
        ),
        'username' => array(
            'Please enter a username' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a username',
            ),
            'The username has already been taken' => array(
                'rule' => 'isUnique',
                'message' => 'That username has already been taken',
            ),
        ),
        'password' => array(
            'The password must be between 5 and 15 characters' => array(
                'rule' => array('between', 5, 15),
                'message' => 'The password must be between 5 and 15 cahracters'
            ),
            'The passwords do not match' => array(
                'rule' => 'matchPasswords',
                'message' => 'Passwords do not match!',
            ),
        ),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Ufile' => array(
			'className' => 'Ufile',
			'foreignKey' => 'person_id',
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

    var $actsAs = array('Containable');


    function matchPasswords($data) {
        if ($data['password'] == $this->data['Person']['password_confirm']) {
            return true;
        }

        $this->invalidate('password_confirm','Passwords do not match!');
        return false;
    }

    function hashPasswords($data) {
        if (isset($this->data['Person']['password'])) {
            $this->data['Person']['password'] = Security::hash($this->data['Person']['password'], null, true);
            return $data;
        }

        return $data;
    }

    function beforeSave() {
        $this->hashPasswords(null);
        return true;
    }

}
?>
