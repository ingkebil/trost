<?php
/* Experiment Test cases generated on: 2011-03-18 17:11:03 : 1300464663*/
App::import('Model', 'Experiment');

class ExperimentTestCase extends CakeTestCase {
	var $fixtures = array('app.experiment', 'app.culture');

	function startTest() {
		$this->Experiment =& ClassRegistry::init('Experiment');
	}

	function endTest() {
		unset($this->Experiment);
		ClassRegistry::flush();
	}

}
?>