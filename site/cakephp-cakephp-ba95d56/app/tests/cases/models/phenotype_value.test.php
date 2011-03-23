<?php
/* PhenotypeValue Test cases generated on: 2011-03-22 17:23:37 : 1300811017*/
App::import('Model', 'PhenotypeValue');

class PhenotypeValueTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_value', 'app.value', 'app.phenotype');

	function startTest() {
		$this->PhenotypeValue =& ClassRegistry::init('PhenotypeValue');
	}

	function endTest() {
		unset($this->PhenotypeValue);
		ClassRegistry::flush();
	}

}
?>