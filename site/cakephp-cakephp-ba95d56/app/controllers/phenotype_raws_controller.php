<?php
class PhenotypeRawsController extends AppController {

	var $name = 'PhenotypeRaws';

	function index() {
		$this->PhenotypeRaw->recursive = 0;
		$this->set('phenotypeRaws', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype raw', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeRaw', $this->PhenotypeRaw->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeRaw->create();
			if ($this->PhenotypeRaw->save($this->data)) {
				$this->Session->setFlash(__('The phenotype raw has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype raw could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->PhenotypeRaw->Phenotype->find('list');
		$raws = $this->PhenotypeRaw->Raw->find('list');
		$this->set(compact('phenotypes', 'raws'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype raw', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeRaw->save($this->data)) {
				$this->Session->setFlash(__('The phenotype raw has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype raw could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeRaw->read(null, $id);
		}
		$phenotypes = $this->PhenotypeRaw->Phenotype->find('list');
		$raws = $this->PhenotypeRaw->Raw->find('list');
		$this->set(compact('phenotypes', 'raws'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype raw', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeRaw->delete($id)) {
			$this->Session->setFlash(__('Phenotype raw deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype raw was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>