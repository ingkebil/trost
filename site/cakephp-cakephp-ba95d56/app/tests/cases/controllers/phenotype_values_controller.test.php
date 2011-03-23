<?php
/* PhenotypeValues Test cases generated on: 2011-03-22 17:23:37 : 1300811017*/
App::import('Controller', 'PhenotypeValues');

class TestPhenotypeValuesController extends PhenotypeValuesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypeValuesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_value', 'app.value', 'app.phenotype');

	function startTest() {
		$this->PhenotypeValues =& new TestPhenotypeValuesController();
		$this->PhenotypeValues->constructClasses();
	}

	function endTest() {
		unset($this->PhenotypeValues);
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