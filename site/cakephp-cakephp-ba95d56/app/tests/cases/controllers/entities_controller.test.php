<?php
/* Entities Test cases generated on: 2011-03-18 17:10:56 : 1300464656*/
App::import('Controller', 'Entities');

class TestEntitiesController extends EntitiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EntitiesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.entity', 'app.phenotype', 'app.phenotype_entity');

	function startTest() {
		$this->Entities =& new TestEntitiesController();
		$this->Entities->constructClasses();
	}

	function endTest() {
		unset($this->Entities);
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