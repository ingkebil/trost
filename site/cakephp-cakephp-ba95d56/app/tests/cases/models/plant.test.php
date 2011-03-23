<?php
/* Plant Test cases generated on: 2011-03-22 17:23:42 : 1300811022*/
App::import('Model', 'Plant');

class PlantTestCase extends CakeTestCase {
	var $fixtures = array('app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype', 'app.program', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value', 'app.value');

	function startTest() {
		$this->Plant =& ClassRegistry::init('Plant');
	}

	function endTest() {
		unset($this->Plant);
		ClassRegistry::flush();
	}

}
?>