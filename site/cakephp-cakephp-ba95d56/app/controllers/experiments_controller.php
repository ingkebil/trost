<?php
class ExperimentsController extends AppController {

	var $name = 'Experiments';

	function index() {
		$this->Experiment->recursive = 0;
		$this->set('experiments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid experiment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('experiment', $this->Experiment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Experiment->create();
			if ($this->Experiment->save($this->data)) {
				$this->Session->setFlash(__('The experiment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The experiment could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid experiment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Experiment->save($this->data)) {
				$this->Session->setFlash(__('The experiment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The experiment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Experiment->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for experiment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Experiment->delete($id)) {
			$this->Session->setFlash(__('Experiment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Experiment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>