<?php
/* Cultures Test cases generated on: 2011-03-22 17:22:51 : 1300810971*/
App::import('Controller', 'Cultures');

class TestCulturesController extends CulturesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CulturesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.culture', 'app.experiment', 'app.plant');

	function startTest() {
		$this->Cultures =& new TestCulturesController();
		$this->Cultures->constructClasses();
	}

	function endTest() {
		unset($this->Cultures);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>