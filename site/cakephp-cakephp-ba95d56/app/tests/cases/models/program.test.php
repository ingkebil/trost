<?php
/* Program Test cases generated on: 2011-03-18 17:11:46 : 1300464706*/
App::import('Model', 'Program');

class ProgramTestCase extends CakeTestCase {
	var $fixtures = array('app.program', 'app.phenotype', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Program =& ClassRegistry::init('Program');
	}

	function endTest() {
		unset($this->Program);
		ClassRegistry::flush();
	}

}
?>