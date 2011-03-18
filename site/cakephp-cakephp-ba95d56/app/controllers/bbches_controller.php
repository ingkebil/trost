<?php
class BbchesController extends AppController {

	var $name = 'Bbches';

	function index() {
		$this->Bbch->recursive = 0;
		$this->set('bbches', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bbch', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bbch', $this->Bbch->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Bbch->create();
			if ($this->Bbch->save($this->data)) {
				$this->Session->setFlash(__('The bbch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bbch could not be saved. Please, try again.', true));
			}
		}
		$species = $this->Bbch->Species->find('list');
		$phenotypes = $this->Bbch->Phenotype->find('list');
		$this->set(compact('species', 'phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid bbch', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Bbch->save($this->data)) {
				$this->Session->setFlash(__('The bbch has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bbch could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Bbch->read(null, $id);
		}
		$species = $this->Bbch->Species->find('list');
		$phenotypes = $this->Bbch->Phenotype->find('list');
		$this->set(compact('species', 'phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bbch', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Bbch->delete($id)) {
			$this->Session->setFlash(__('Bbch deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Bbch was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>