<?php
/* PhenotypeEntities Test cases generated on: 2011-03-18 17:11:28 : 1300464688*/
App::import('Controller', 'PhenotypeEntities');

class TestPhenotypeEntitiesController extends PhenotypeEntitiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypeEntitiesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_entity', 'app.phenotype', 'app.entity');

	function startTest() {
		$this->PhenotypeEntities =& new TestPhenotypeEntitiesController();
		$this->PhenotypeEntities->constructClasses();
	}

	function endTest() {
		unset($this->PhenotypeEntities);
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