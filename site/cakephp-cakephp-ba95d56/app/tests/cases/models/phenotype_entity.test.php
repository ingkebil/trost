<?php
/* PhenotypeEntity Test cases generated on: 2011-03-22 17:23:16 : 1300810996*/
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