<?php
class PhenotypeValuesController extends AppController {

	var $name = 'PhenotypeValues';

	function index() {
		$this->PhenotypeValue->recursive = 0;
		$this->set('phenotypeValues', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype value', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeValue', $this->PhenotypeValue->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeValue->create();
			if ($this->PhenotypeValue->save($this->data)) {
				$this->Session->setFlash(__('The phenotype value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype value could not be saved. Please, try again.', true));
			}
		}
		$values = $this->PhenotypeValue->Value->find('list');
		$phenotypes = $this->PhenotypeValue->Phenotype->find('list');
		$this->set(compact('values', 'phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype value', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeValue->save($this->data)) {
				$this->Session->setFlash(__('The phenotype value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype value could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeValue->read(null, $id);
		}
		$values = $this->PhenotypeValue->Value->find('list');
		$phenotypes = $this->PhenotypeValue->Phenotype->find('list');
		$this->set(compact('values', 'phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype value', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeValue->delete($id)) {
			$this->Session->setFlash(__('Phenotype value deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype value was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>