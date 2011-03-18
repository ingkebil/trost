<?php
/* Entity Test cases generated on: 2011-03-18 17:10:56 : 1300464656*/
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