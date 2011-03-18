<?php
/* Sample Test cases generated on: 2011-03-18 17:11:56 : 1300464716*/
App::import('Model', 'Sample');

class SampleTestCase extends CakeTestCase {
	var $fixtures = array('app.sample', 'app.plant', 'app.culture', 'app.experiment', 'app.phenotype', 'app.program', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Sample =& ClassRegistry::init('Sample');
	}

	function endTest() {
		unset($this->Sample);
		ClassRegistry::flush();
	}

}
?>