<?php
/* Species Test cases generated on: 2011-03-22 17:23:58 : 1300811038*/
App::import('Controller', 'Species');

class TestSpeciesController extends SpeciesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SpeciesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.species', 'app.bbch', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_bbch', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value', 'app.value');

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