<?php
/* Values Test cases generated on: 2011-03-22 17:24:02 : 1300811042*/
App::import('Controller', 'Values');

class TestValuesController extends ValuesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ValuesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.value', 'app.phenotype', 'app.program', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value');

	function startTest() {
		$this->Values =& new TestValuesController();
		$this->Values->constructClasses();
	}

	function endTest() {
		unset($this->Values);
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