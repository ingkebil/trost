<?php
/* Value Test cases generated on: 2011-03-22 17:24:02 : 1300811042*/
App::import('Model', 'Value');

class ValueTestCase extends CakeTestCase {
	var $fixtures = array('app.value', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value');

	function startTest() {
		$this->Value =& ClassRegistry::init('Value');
	}

	function endTest() {
		unset($this->Value);
		ClassRegistry::flush();
	}

}
?>