<?php
/* Ufilekeyword Test cases generated on: 2011-07-19 11:38:56 : 1311068336*/
App::import('Model', 'Ufilekeyword');

class UfilekeywordTestCase extends CakeTestCase {
	function startTest() {
		$this->Ufilekeyword =& ClassRegistry::init('Ufilekeyword');
	}

	function endTest() {
		unset($this->Ufilekeyword);
		ClassRegistry::flush();
	}

}
?>