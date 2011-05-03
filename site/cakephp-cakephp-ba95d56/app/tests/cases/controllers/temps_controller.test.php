<?php
/* Temps Test cases generated on: 2011-05-03 17:08:24 : 1304435304*/
App::import('Controller', 'Temps');

class TestTempsController extends TempsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TempsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.temp');

	function startTest() {
		$this->Temps =& new TestTempsController();
		$this->Temps->constructClasses();
	}

	function endTest() {
		unset($this->Temps);
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