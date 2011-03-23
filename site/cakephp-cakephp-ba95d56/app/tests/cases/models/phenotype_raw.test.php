<?php
/* PhenotypeRaw Test cases generated on: 2011-03-22 17:23:34 : 1300811014*/
App::import('Model', 'PhenotypeRaw');

class PhenotypeRawTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_raw', 'app.phenotype', 'app.raw');

	function startTest() {
		$this->PhenotypeRaw =& ClassRegistry::init('PhenotypeRaw');
	}

	function endTest() {
		unset($this->PhenotypeRaw);
		ClassRegistry::flush();
	}

}
?>