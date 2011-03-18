<?php
class PhenotypeEntitiesController extends AppController {

	var $name = 'PhenotypeEntities';

	function index() {
		$this->PhenotypeEntity->recursive = 0;
		$this->set('phenotypeEntities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype entity', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeEntity', $this->PhenotypeEntity->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeEntity->create();
			if ($this->PhenotypeEntity->save($this->data)) {
				$this->Session->setFlash(__('The phenotype entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype entity could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->PhenotypeEntity->Phenotype->find('list');
		$entities = $this->PhenotypeEntity->Entity->find('list');
		$this->set(compact('phenotypes', 'entities'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype entity', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeEntity->save($this->data)) {
				$this->Session->setFlash(__('The phenotype entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype entity could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeEntity->read(null, $id);
		}
		$phenotypes = $this->PhenotypeEntity->Phenotype->find('list');
		$entities = $this->PhenotypeEntity->Entity->find('list');
		$this->set(compact('phenotypes', 'entities'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype entity', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeEntity->delete($id)) {
			$this->Session->setFlash(__('Phenotype entity deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype entity was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>