<?php
/* Experiments Test cases generated on: 2011-03-22 17:23:10 : 1300810990*/
App::import('Controller', 'Experiments');

class TestExperimentsController extends ExperimentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExperimentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.experiment', 'app.culture', 'app.plant');

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