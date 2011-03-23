<?php
/* Raw Test cases generated on: 2011-03-22 17:23:50 : 1300811030*/
App::import('Model', 'Raw');

class RawTestCase extends CakeTestCase {
	var $fixtures = array('app.raw', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.phenotype_value', 'app.value');

	function startTest() {
		$this->Raw =& ClassRegistry::init('Raw');
	}

	function endTest() {
		unset($this->Raw);
		ClassRegistry::flush();
	}

}
?>