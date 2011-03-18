<?php
/* Plant Test cases generated on: 2011-03-18 17:11:42 : 1300464702*/
App::import('Model', 'Plant');

class PlantTestCase extends CakeTestCase {
	var $fixtures = array('app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype', 'app.program', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Plant =& ClassRegistry::init('Plant');
	}

	function endTest() {
		unset($this->Plant);
		ClassRegistry::flush();
	}

}
?>