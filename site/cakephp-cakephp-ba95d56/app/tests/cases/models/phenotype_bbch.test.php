<?php
/* PhenotypeBbch Test cases generated on: 2011-03-18 17:11:23 : 1300464683*/
App::import('Model', 'PhenotypeBbch');

class PhenotypeBbchTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_bbch', 'app.phenotype', 'app.bbch', 'app.species');

	function startTest() {
		$this->PhenotypeBbch =& ClassRegistry::init('PhenotypeBbch');
	}

	function endTest() {
		unset($this->PhenotypeBbch);
		ClassRegistry::flush();
	}

}
?>