<?php
/* Phenotype Test cases generated on: 2011-03-22 17:23:39 : 1300811019*/
App::import('Model', 'Phenotype');

class PhenotypeTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype', 'app.program', 'app.plant', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value', 'app.value');

	function startTest() {
		$this->Phenotype =& ClassRegistry::init('Phenotype');
	}

	function endTest() {
		unset($this->Phenotype);
		ClassRegistry::flush();
	}

}
?>