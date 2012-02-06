<?php
class Temp extends AppModel {
	var $name = 'Temp';
	var $validate = array(
		'datum' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'precipitation' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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


    /**
     * Returns all the duplicate rows: same location_id and date.
     */
    function find_duplicates() {
        return $this->find('all', array(
            'conditions' => array(
                'Temp.id != Temp2.id',
            ),
            'joins' => array(
                array(
                    'table' => 'temps',
                    'alias' => 'Temp2',
                    'type'  => 'inner',
                    'conditions' => array(
                        'Temp.datum = Temp2.datum',
                        'Temp.location_id = Temp2.location_id'
                    )
                )
            ),
        ));
    }
}
?>
