<?php
/* Ufile Test cases generated on: 2011-07-19 11:40:19 : 1311068419*/
App::import('Model', 'Ufile');

class UfileTestCase extends CakeTestCase {
	function startTest() {
		$this->Ufile =& ClassRegistry::init('Ufile');
	}

	function endTest() {
		unset($this->Ufile);
		ClassRegistry::flush();
	}

}
?>