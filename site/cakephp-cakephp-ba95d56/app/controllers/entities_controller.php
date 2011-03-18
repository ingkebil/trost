<?php
class EntitiesController extends AppController {

	var $name = 'Entities';

	function index() {
		$this->Entity->recursive = 0;
		$this->set('entities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid entity', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('entity', $this->Entity->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Entity->create();
			if ($this->Entity->save($this->data)) {
				$this->Session->setFlash(__('The entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entity could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->Entity->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid entity', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Entity->save($this->data)) {
				$this->Session->setFlash(__('The entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entity could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Entity->read(null, $id);
		}
		$phenotypes = $this->Entity->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for entity', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Entity->delete($id)) {
			$this->Session->setFlash(__('Entity deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Entity was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>