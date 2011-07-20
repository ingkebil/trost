<?php
/* Ufiles Test cases generated on: 2011-07-19 11:38:49 : 1311068329*/
App::import('Controller', 'Ufiles');

class TestUfilesController extends UfilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class UfilesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.ufile', 'app.ufilekeyword');

	function startTest() {
		$this->Ufiles =& new TestUfilesController();
		$this->Ufiles->constructClasses();
	}

	function endTest() {
		unset($this->Ufiles);
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