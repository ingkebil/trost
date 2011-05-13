<?php
class TempsController extends AppController {

	var $name = 'Temps';

	function index() {
		$this->Temp->recursive = 0;
		$this->set('temps', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid temp', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('temp', $this->Temp->read(null, $id));
	}

	function erature() {
		if (!empty($this->data)) {
			$this->Temp->create();
			if ($this->Temp->save($this->data)) {
				$this->Session->setFlash(__('The temp has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp could not be saved. Please, try again.', true));
			}
		}
        $this->set('locations', $this->Temp->Location->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid temp', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Temp->save($this->data)) {
				$this->Session->setFlash(__('The temp has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Temp->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for temp', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Temp->delete($id)) {
			$this->Session->setFlash(__('Temp deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Temp was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
