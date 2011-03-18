<?php
/* Bbch Test cases generated on: 2011-03-18 17:11:07 : 1300464667*/
App::import('Model', 'Bbch');

class BbchTestCase extends CakeTestCase {
	var $fixtures = array('app.bbch', 'app.species', 'app.phenotype', 'app.phenotype_bbch');

	function startTest() {
		$this->Bbch =& ClassRegistry::init('Bbch');
	}

	function endTest() {
		unset($this->Bbch);
		ClassRegistry::flush();
	}

}
?>