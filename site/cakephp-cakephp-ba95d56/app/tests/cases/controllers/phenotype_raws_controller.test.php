<?php
/* PhenotypeRaws Test cases generated on: 2011-03-22 17:23:34 : 1300811014*/
App::import('Controller', 'PhenotypeRaws');

class TestPhenotypeRawsController extends PhenotypeRawsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypeRawsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_raw', 'app.phenotype', 'app.raw');

	function startTest() {
		$this->PhenotypeRaws =& new TestPhenotypeRawsController();
		$this->PhenotypeRaws->constructClasses();
	}

	function endTest() {
		unset($this->PhenotypeRaws);
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