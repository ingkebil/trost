<?php
class PhenotypeBbchesController extends AppController {

	var $name = 'PhenotypeBbches';

	function index() {
		$this->PhenotypeBbch->recursive = 0;
		$this->set('phenotypeBbches', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype bbch', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotypeBbch', $this->PhenotypeBbch->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PhenotypeBbch->create();
			if ($this->PhenotypeBbch->save($this->data)) {
				$this->Session->setFlash(__('The phenotype bbch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype bbch could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->PhenotypeBbch->Phenotype->find('list');
		$bbches = $this->PhenotypeBbch->Bbch->find('list');
		$this->set(compact('phenotypes', 'bbches'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype bbch', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PhenotypeBbch->save($this->data)) {
				$this->Session->setFlash(__('The phenotype bbch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype bbch could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PhenotypeBbch->read(null, $id);
		}
		$phenotypes = $this->PhenotypeBbch->Phenotype->find('list');
		$bbches = $this->PhenotypeBbch->Bbch->find('list');
		$this->set(compact('phenotypes', 'bbches'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype bbch', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PhenotypeBbch->delete($id)) {
			$this->Session->setFlash(__('Phenotype bbch deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype bbch was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>