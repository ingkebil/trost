<?php
/* Experiment Test cases generated on: 2011-03-22 17:23:09 : 1300810989*/
App::import('Model', 'Experiment');

class ExperimentTestCase extends CakeTestCase {
	var $fixtures = array('app.experiment', 'app.culture', 'app.plant');

	function startTest() {
		$this->Experiment =& ClassRegistry::init('Experiment');
	}

	function endTest() {
		unset($this->Experiment);
		ClassRegistry::flush();
	}

}
?>