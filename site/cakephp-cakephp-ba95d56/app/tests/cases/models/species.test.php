<?php
/* Species Test cases generated on: 2011-03-18 17:12:00 : 1300464720*/
App::import('Model', 'Species');

class SpeciesTestCase extends CakeTestCase {
	var $fixtures = array('app.species', 'app.bbch', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Species =& ClassRegistry::init('Species');
	}

	function endTest() {
		unset($this->Species);
		ClassRegistry::flush();
	}

}
?>