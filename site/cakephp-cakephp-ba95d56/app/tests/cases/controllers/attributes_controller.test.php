<?php
/* Attributes Test cases generated on: 2011-03-20 17:03:42 : 1300637022*/
App::import('Controller', 'Attributes');

class TestAttributesController extends AttributesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AttributesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Attributes =& new TestAttributesController();
		$this->Attributes->constructClasses();
	}

	function endTest() {
		unset($this->Attributes);
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