<?php
class PhenotypeSamplesController extends AppController {

	var $name = 'PhenotypeSamples';

	function index() {
		$this->PhenotypeSample->recursive = 0;
		$this->set('phenotypeSamples', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype sample', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeSample', $this->PhenotypeSample->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeSample->create();
			if ($this->PhenotypeSample->save($this->data)) {
				$this->Session->setFlash(__('The phenotype sample has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype sample could not be saved. Please, try again.', true));
			}
		}
		$samples = $this->PhenotypeSample->Sample->find('list');
		$phenotypes = $this->PhenotypeSample->Phenotype->find('list');
		$this->set(compact('samples', 'phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype sample', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeSample->save($this->data)) {
				$this->Session->setFlash(__('The phenotype sample has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype sample could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeSample->read(null, $id);
		}
		$samples = $this->PhenotypeSample->Sample->find('list');
		$phenotypes = $this->PhenotypeSample->Phenotype->find('list');
		$this->set(compact('samples', 'phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype sample', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeSample->delete($id)) {
			$this->Session->setFlash(__('Phenotype sample deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype sample was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>