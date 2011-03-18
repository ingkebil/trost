<?php
/* Attributes Test cases generated on: 2011-03-18 17:10:50 : 1300464650*/
App::import('Controller', 'Attributes');

class TestAttributesController extends AttributesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AttributesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute', 'app.phenotype', 'app.phenotype_attribute');

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