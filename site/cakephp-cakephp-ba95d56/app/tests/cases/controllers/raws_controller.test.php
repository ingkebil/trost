<?php
/* Raws Test cases generated on: 2011-03-18 17:11:51 : 1300464711*/
App::import('Controller', 'Raws');

class TestRawsController extends RawsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RawsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.raw', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw');

	function startTest() {
		$this->Raws =& new TestRawsController();
		$this->Raws->constructClasses();
	}

	function endTest() {
		unset($this->Raws);
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