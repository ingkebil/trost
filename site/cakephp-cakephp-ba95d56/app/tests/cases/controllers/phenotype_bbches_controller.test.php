<?php
/* PhenotypeBbches Test cases generated on: 2011-03-22 17:23:14 : 1300810994*/
App::import('Controller', 'PhenotypeBbches');

class TestPhenotypeBbchesController extends PhenotypeBbchesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhenotypeBbchesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phenotype_bbch', 'app.phenotype', 'app.bbch', 'app.species');

	function startTest() {
		$this->PhenotypeBbches =& new TestPhenotypeBbchesController();
		$this->PhenotypeBbches->constructClasses();
	}

	function endTest() {
		unset($this->PhenotypeBbches);
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