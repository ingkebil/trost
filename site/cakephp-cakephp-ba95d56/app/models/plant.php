<?php
class Plant extends AppModel {

	var $name = 'Plant';

	var $validate = array(
		'culture_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a culture',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

}
?>
