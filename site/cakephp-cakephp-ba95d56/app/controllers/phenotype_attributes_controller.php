<?php
class PhenotypeAttributesController extends AppController {

	var $name = 'PhenotypeAttributes';

	function index() {
		$this->PhenotypeAttribute->recursive = 0;
		$this->set('phenotypeAttributes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype attribute', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeAttribute', $this->PhenotypeAttribute->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeAttribute->create();
			if ($this->PhenotypeAttribute->save($this->data)) {
				$this->Session->setFlash(__('The phenotype attribute has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype attribute could not be saved. Please, try again.', true));
			}
		}
		$attributes = $this->PhenotypeAttribute->Attribute->find('list');
		$phenotypes = $this->PhenotypeAttribute->Phenotype->find('list');
		$this->set(compact('attributes', 'phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype attribute', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeAttribute->save($this->data)) {
				$this->Session->setFlash(__('The phenotype attribute has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype attribute could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeAttribute->read(null, $id);
		}
		$attributes = $this->PhenotypeAttribute->Attribute->find('list');
		$phenotypes = $this->PhenotypeAttribute->Phenotype->find('list');
		$this->set(compact('attributes', 'phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype attribute', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeAttribute->delete($id)) {
			$this->Session->setFlash(__('Phenotype attribute deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype attribute was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>