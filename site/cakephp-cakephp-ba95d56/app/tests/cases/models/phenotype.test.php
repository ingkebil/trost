<?php
/* Phenotype Test cases generated on: 2011-03-18 17:11:39 : 1300464699*/
App::import('Model', 'Phenotype');

class PhenotypeTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype', 'app.program', 'app.plant', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Phenotype =& ClassRegistry::init('Phenotype');
	}

	function endTest() {
		unset($this->Phenotype);
		ClassRegistry::flush();
	}

}
?>