<?php
class Raw extends AppModel {
	var $name = 'Raw';
    var $actsAs = array('Containable');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Phenotype' => array(
			'className' => 'Phenotype',
			'joinTable' => 'phenotype_raws',
			'foreignKey' => 'raw_id',
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
