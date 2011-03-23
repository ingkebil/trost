<?php
/* Bbch Test cases generated on: 2011-03-22 17:22:46 : 1300810966*/
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