<?php
class PhenotypeValue extends AppModel {
	var $name = 'PhenotypeValue';
    var $actsAs = array('Containable');
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

    function fetchLine($params) {
        return $this->find('all', 
            am(
                $params,
                array(
                    'recursive' => -1,
                    'fields' => array('Phenotype.*', 'Sample.*', 'PhenotypeEntity.*', 'PhenotypeValue.*', 'Value.*'),
                    #'contain' => array('Phenotype', 'Phenotype.PhenotypeEntity', 'Phenotype.Sample'),
                    'joins' => array(
                        array(
                            'table' => 'phenotypes',
                            'alias' => 'Phenotype',
                            'type'  => 'left',
                            'conditions' => array('PhenotypeValue.phenotype_id = Phenotype.id')
                        ),
                        array(
                            'table' => 'phenotype_entities',
                            'alias' => 'PhenotypeEntity',
                            'type'  => 'left',
                            'conditions' => array('PhenotypeEntity.phenotype_id = Phenotype.id')
                        ),
                        array(
                            'table' => 'samples',
                            'alias' => 'Sample',
                            'type'  => 'left',
                            'conditions' => array('Sample.id' => 'Phenotype.sample_id')
                        ),
                        array(
                            'table' => '`values`',
                            'alias' => 'Value',
                            'type'  => '',
                            'conditions' => array('Value.id' => 'PhenotypeValue.value_id')
                        )
                    ),
                )
            )
        );
    }
}
?>
