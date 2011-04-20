<?php
/* Cultures Test cases generated on: 2011-04-19 16:35:41 : 1303223741*/
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