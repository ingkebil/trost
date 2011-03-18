<?php
/* PhenotypeAttribute Test cases generated on: 2011-03-18 17:11:18 : 1300464678*/
App::import('Model', 'PhenotypeAttribute');

class PhenotypeAttributeTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_attribute', 'app.attribute', 'app.phenotype');

	function startTest() {
		$this->PhenotypeAttribute =& ClassRegistry::init('PhenotypeAttribute');
	}

	function endTest() {
		unset($this->PhenotypeAttribute);
		ClassRegistry::flush();
	}

}
?>