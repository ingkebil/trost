<?php
class PhenotypesController extends AppController {

	var $name = 'Phenotypes';

	function index() {
		$this->Phenotype->recursive = 0;
		$this->set('phenotypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotype', $this->Phenotype->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Phenotype->create();
			if ($this->Phenotype->save($this->data)) {
				$this->Session->setFlash(__('The phenotype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
			}
		}
		$programs = $this->Phenotype->Program->find('list');
		$plants = $this->Phenotype->Plant->find('list');
		$this->set(compact('programs', 'plants'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Phenotype->save($this->data)) {
				$this->Session->setFlash(__('The phenotype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Phenotype->read(null, $id);
		}
		$programs = $this->Phenotype->Program->find('list');
		$plants = $this->Phenotype->Plant->find('list');
		$this->set(compact('programs', 'plants'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Phenotype->delete($id)) {
			$this->Session->setFlash(__('Phenotype deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>