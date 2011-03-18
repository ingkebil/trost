<?php
/* Attribute Test cases generated on: 2011-03-18 17:10:49 : 1300464649*/
App::import('Model', 'Attribute');

class AttributeTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute', 'app.phenotype', 'app.phenotype_attribute');

	function startTest() {
		$this->Attribute =& ClassRegistry::init('Attribute');
	}

	function endTest() {
		unset($this->Attribute);
		ClassRegistry::flush();
	}

}
?>