<?php
/* Species Test cases generated on: 2011-03-18 17:12:01 : 1300464721*/
App::import('Controller', 'Species');

class TestSpeciesController extends SpeciesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SpeciesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.species', 'app.bbch', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Species =& new TestSpeciesController();
		$this->Species->constructClasses();
	}

	function endTest() {
		unset($this->Species);
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