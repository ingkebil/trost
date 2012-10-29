<?php
class PhenotypePlantsController extends AppController {

	var $name = 'PhenotypePlants';

	function index() {
		$this->PhenotypePlant->recursive = 0;
		$this->set('phenotypePlants', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype plant', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypePlant', $this->PhenotypePlant->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypePlant->create();
			if ($this->PhenotypePlant->save($this->data)) {
				$this->Session->setFlash(__('The phenotype plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype plant could not be saved. Please, try again.', true));
			}
		}
		$plants = $this->PhenotypePlant->Plant->find('list');
		$phenotypes = $this->PhenotypePlant->Phenotype->find('list');
		$this->set(compact('plants', 'phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype plant', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypePlant->save($this->data)) {
				$this->Session->setFlash(__('The phenotype plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype plant could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypePlant->read(null, $id);
		}
		$plants = $this->PhenotypePlant->Plant->find('list');
		$phenotypes = $this->PhenotypePlant->Phenotype->find('list');
		$this->set(compact('plants', 'phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype plant', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypePlant->delete($id)) {
			$this->Session->setFlash(__('Phenotype plant deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype plant was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>