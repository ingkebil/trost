<?php
/* Experiments Test cases generated on: 2011-03-18 17:11:03 : 1300464663*/
App::import('Controller', 'Experiments');

class TestExperimentsController extends ExperimentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExperimentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.experiment', 'app.culture');

	function startTest() {
		$this->Experiments =& new TestExperimentsController();
		$this->Experiments->constructClasses();
	}

	function endTest() {
		unset($this->Experiments);
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