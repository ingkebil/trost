<?php
/* Samples Test cases generated on: 2012-10-29 16:26:52 : 1351524412*/
App::import('Controller', 'Samples');

class TestSamplesController extends SamplesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SamplesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.sample', 'app.sample_plant', 'app.plant', 'app.culture', 'app.experiment', 'app.subspecies', 'app.phenotype', 'app.program', 'app.entity', 'app.phenotype_entity', 'app.value', 'app.phenotype_value', 'app.phenotype_bbch', 'app.bbch', 'app.species', 'app.phenotype_plant', 'app.phenotype_raw', 'app.raw', 'app.phenotype_sample');

	function startTest() {
		$this->Samples =& new TestSamplesController();
		$this->Samples->constructClasses();
	}

	function endTest() {
		unset($this->Samples);
		ClassRegistry::flush();
	}

}
?>