<?php
/* Samples Test cases generated on: 2011-03-18 17:11:57 : 1300464717*/
App::import('Controller', 'Samples');

class TestSamplesController extends SamplesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SamplesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.sample', 'app.plant', 'app.culture', 'app.experiment', 'app.phenotype', 'app.program', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Samples =& new TestSamplesController();
		$this->Samples->constructClasses();
	}

	function endTest() {
		unset($this->Samples);
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