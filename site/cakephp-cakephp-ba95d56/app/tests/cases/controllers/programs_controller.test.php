<?php
/* Programs Test cases generated on: 2011-03-18 17:11:46 : 1300464706*/
App::import('Controller', 'Programs');

class TestProgramsController extends ProgramsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProgramsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.program', 'app.phenotype', 'app.plant', 'app.culture', 'app.experiment', 'app.sample', 'app.phenotype_attribute', 'app.attribute', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_entity', 'app.entity', 'app.phenotype_raw', 'app.raw');

	function startTest() {
		$this->Programs =& new TestProgramsController();
		$this->Programs->constructClasses();
	}

	function endTest() {
		unset($this->Programs);
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