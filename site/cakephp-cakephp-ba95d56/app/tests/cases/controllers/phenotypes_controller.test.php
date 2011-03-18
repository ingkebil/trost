<?php
/* Phenotypes Test cases generated on: 2011-03-18 17:11:39 : 1300464699*/
App::import('Controller', 'Phenotypes');

class TestPhenotypesController extends PhenotypesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype', 'app.program', 'app.plant', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Phenotypes =& new TestPhenotypesController();
		$this->Phenotypes->constructClasses();
	}

	function endTest() {
		unset($this->Phenotypes);
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