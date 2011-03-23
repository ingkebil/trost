<?php
/* Plants Test cases generated on: 2011-03-22 17:23:42 : 1300811022*/
App::import('Controller', 'Plants');

class TestPlantsController extends PlantsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PlantsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype', 'app.program', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw', 'app.phenotype_value', 'app.value');

	function startTest() {
		$this->Plants =& new TestPlantsController();
		$this->Plants->constructClasses();
	}

	function endTest() {
		unset($this->Plants);
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