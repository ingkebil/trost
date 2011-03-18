<?php
class Attribute extends AppModel {
	var $name = 'Attribute';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
		'Phenotype' => array(
			'className' => 'Phenotype',
			'joinTable' => 'phenotype_attributes',
			'foreignKey' => 'attribute_id',
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