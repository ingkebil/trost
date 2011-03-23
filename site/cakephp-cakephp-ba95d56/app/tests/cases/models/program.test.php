<?php
/* Program Test cases generated on: 2011-03-22 17:23:46 : 1300811026*/
App::import('Model', 'Program');

class ProgramTestCase extends CakeTestCase {
	var $fixtures = array('app.program', 'app.phenotype', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value', 'app.value');

	function startTest() {
		$this->Program =& ClassRegistry::init('Program');
	}

	function endTest() {
		unset($this->Program);
		ClassRegistry::flush();
	}

}
?>