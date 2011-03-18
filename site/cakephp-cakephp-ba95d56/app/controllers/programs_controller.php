<?php
class ProgramsController extends AppController {

	var $name = 'Programs';

	function index() {
		$this->Program->recursive = 0;
		$this->set('programs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid program', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('program', $this->Program->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Program->create();
			if ($this->Program->save($this->data)) {
				$this->Session->setFlash(__('The program has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid program', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Program->save($this->data)) {
				$this->Session->setFlash(__('The program has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Program->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for program', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Program->delete($id)) {
			$this->Session->setFlash(__('Program deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Program was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>