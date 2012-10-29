<?php
class SubspeciesController extends AppController {

	var $name = 'Subspecies';
    var $uses = array('Subspecies');

	function index() {
		$this->Subspecies->recursive = 0;
		$this->set('subspecies', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid subspecies', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('subspecies', $this->Subspecies->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Subspecies->create();
			if ($this->Subspecies->save($this->data)) {
				$this->Session->setFlash(__('The subspecies has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subspecies could not be saved. Please, try again.', true));
			}
		}
		$plants = $this->Subspecies->Plant->find('list');
		$this->set(compact('plants'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid subspecies', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Subspecies->save($this->data)) {
				$this->Session->setFlash(__('The subspecies has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subspecies could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subspecies->read(null, $id);
		}
		$plants = $this->Subspecies->Plant->find('list');
		$this->set(compact('plants'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for subspecies', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Subspecies->delete($id)) {
			$this->Session->setFlash(__('Subspecies deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Subspecies was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
