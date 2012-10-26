<?php
class Phenotype extends AppModel {
	var $name = 'Phenotype';
    var $actsAs = array('Containable');
	var $validate = array(
		'program_id' => array(
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
		'Program' => array(
			'className' => 'Program',
			'foreignKey' => 'program_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Entity' => array(
			'className' => 'Entity',
			'foreignKey' => 'entity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Value' => array(
			'className' => 'Value',
			'foreignKey' => 'value_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'PhenotypeBbch' => array(
			'className' => 'PhenotypeBbch',
			'foreignKey' => 'phenotype_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PhenotypePlants' => array(
			'className' => 'PhenotypePlant',
			'foreignKey' => 'phenotype_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PhenotypeRaw' => array(
			'className' => 'PhenotypeRaw',
			'foreignKey' => 'phenotype_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PhenotypeSample' => array(
			'className' => 'PhenotypeSample',
			'foreignKey' => 'phenotype_id',
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
        'Plant' => array(
            'className' => 'Plant',
            'joinTable' => 'phenotype_plants',
            'foreignKey' => 'phenotype_id',
            'associationForeignKey' => 'plant_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''),
       'Sample' => array(
            'className' => 'Sample',
            'joinTable' => 'phenotype_samples',
            'foreignKey' => 'phenotype_id',
            'associationForeignKey' => 'sample_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''),
       'Bbch' => array(
            'className' => 'Bbch',
            'joinTable' => 'phenotype_bbches',
            'foreignKey' => 'phenotype_id',
            'associationForeignKey' => 'bbch_id',
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

    function fetchLine($params) {
        $default = array(
            'recursive' => -1,
            'fields' => array('Phenotype.*', 'Sample.*', 'PhenotypeEntity.*', 'PhenotypeValue.*', 'Value.*'),
            'joins' => array(
                array(
                    'table' => 'phenotype_values',
                    'alias' => 'PhenotypeValue',
                    'type'  => 'left',
                    'conditions' => array('PhenotypeValue.phenotype_id = Phenotype.id'),
                ),
                array(
                    'table' => 'phenotype_entities',
                    'alias' => 'PhenotypeEntity',
                    'type'  => 'left',
                    'conditions' => array('PhenotypeEntity.phenotype_id = Phenotype.id'),
                ),
                array(
                    'table' => '`values`',
                    'alias' => 'Value',
                    'type'  => 'left',
                    'conditions' => array('PhenotypeValue.value_id = Value.id'),
                ),
                array(
                    'table' => 'samples',
                    'alias' => 'Sample',
                    'type'  => 'left',
                    'conditions' => array('Sample.id = Phenotype.sample_id')
                ),
            )
        );
        return $this->find('all',
            array_merge_recursive(
                $default,
                $params
            )
        );
    }


}
?>
