<?php
/* Entity Test cases generated on: 2011-03-22 17:23:00 : 1300810980*/
App::import('Model', 'Entity');

class EntityTestCase extends CakeTestCase {
	var $fixtures = array('app.entity', 'app.phenotype', 'app.phenotype_entity');

	function startTest() {
		$this->Entity =& ClassRegistry::init('Entity');
	}

	function endTest() {
		unset($this->Entity);
		ClassRegistry::flush();
	}

}
?>