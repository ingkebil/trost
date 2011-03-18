<?php
/* Culture Test cases generated on: 2011-03-18 17:11:11 : 1300464671*/
App::import('Model', 'Culture');

class CultureTestCase extends CakeTestCase {
	var $fixtures = array('app.culture', 'app.experiment', 'app.plant');

	function startTest() {
		$this->Culture =& ClassRegistry::init('Culture');
	}

	function endTest() {
		unset($this->Culture);
		ClassRegistry::flush();
	}

}
?>