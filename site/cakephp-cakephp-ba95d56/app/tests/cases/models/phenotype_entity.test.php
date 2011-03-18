<?php
/* PhenotypeEntity Test cases generated on: 2011-03-18 17:11:27 : 1300464687*/
App::import('Model', 'PhenotypeEntity');

class PhenotypeEntityTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_entity', 'app.phenotype', 'app.entity');

	function startTest() {
		$this->PhenotypeEntity =& ClassRegistry::init('PhenotypeEntity');
	}

	function endTest() {
		unset($this->PhenotypeEntity);
		ClassRegistry::flush();
	}

}
?>