<?php
/* Raw Test cases generated on: 2011-03-18 17:11:51 : 1300464711*/
App::import('Model', 'Raw');

class RawTestCase extends CakeTestCase {
	var $fixtures = array('app.raw', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw');

	function startTest() {
		$this->Raw =& ClassRegistry::init('Raw');
	}

	function endTest() {
		unset($this->Raw);
		ClassRegistry::flush();
	}

}
?>