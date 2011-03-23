<?php
/* Bbches Test cases generated on: 2011-03-22 17:22:47 : 1300810967*/
App::import('Controller', 'Bbches');

class TestBbchesController extends BbchesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BbchesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.bbch', 'app.species', 'app.phenotype', 'app.phenotype_bbch');

	function startTest() {
		$this->Bbches =& new TestBbchesController();
		$this->Bbches->constructClasses();
	}

	function endTest() {
		unset($this->Bbches);
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