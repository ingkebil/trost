<?php
/* Temp Test cases generated on: 2011-05-03 17:08:24 : 1304435304*/
App::import('Model', 'Temp');

class TempTestCase extends CakeTestCase {
	var $fixtures = array('app.temp');

	function startTest() {
		$this->Temp =& ClassRegistry::init('Temp');
	}

	function endTest() {
		unset($this->Temp);
		ClassRegistry::flush();
	}

}
?>