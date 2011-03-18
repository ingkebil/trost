<?php
class SpeciesController extends AppController {

	var $name = 'Species';

	function index() {
		$this->Species->recursive = 0;
		$this->set('species', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid species', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('species', $this->Species->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Species->create();
			if ($this->Species->save($this->data)) {
				$this->Session->setFlash(__('The species has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The species could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid species', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Species->save($this->data)) {
				$this->Session->setFlash(__('The species has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The species could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Species->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for species', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Species->delete($id)) {
			$this->Session->setFlash(__('Species deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Species was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>