<?php
class ValuesController extends AppController {

	var $name = 'Values';

	function index() {
		$this->Value->recursive = 0;
		$this->set('values', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid value', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('value', $this->Value->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Value->create();
			if ($this->Value->save($this->data)) {
				$this->Session->setFlash(__('The value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->Value->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid value', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Value->save($this->data)) {
				$this->Session->setFlash(__('The value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Value->read(null, $id);
		}
		$phenotypes = $this->Value->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for value', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Value->delete($id)) {
			$this->Session->setFlash(__('Value deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Value was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>