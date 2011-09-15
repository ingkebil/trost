<?php
class Sample extends AppModel {

	var $name = 'Sample';

    var $hasMany = array(
        'Phenotype' => array(
			'className' => 'Phenotype',
			'foreignKey' => 'sample_id',
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

	var $belongsTo = array(
		'Plant' => array(
			'className' => 'Plant',
			'foreignKey' => 'plant_id',
		)
	);

}
?>
