<?php
/* PhenotypeAttributes Test cases generated on: 2011-03-18 17:11:18 : 1300464678*/
App::import('Controller', 'PhenotypeAttributes');

class TestPhenotypeAttributesController extends PhenotypeAttributesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypeAttributesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_attribute', 'app.attribute', 'app.phenotype');

	function startTest() {
		$this->PhenotypeAttributes =& new TestPhenotypeAttributesController();
		$this->PhenotypeAttributes->constructClasses();
	}

	function endTest() {
		unset($this->PhenotypeAttributes);
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