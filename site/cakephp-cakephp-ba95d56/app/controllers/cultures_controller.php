<?php
class CulturesController extends AppController {

	var $name = 'Cultures';

	function index() {
		$this->Culture->recursive = 0;
		$this->set('cultures', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid culture', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('culture', $this->Culture->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Culture->create();
			if ($this->Culture->save($this->data)) {
				$this->Session->setFlash(__('The culture has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The culture could not be saved. Please, try again.', true));
			}
		}
		$experiments = $this->Culture->Experiment->find('list');
		$this->set(compact('experiments'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid culture', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Culture->save($this->data)) {
				$this->Session->setFlash(__('The culture has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The culture could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Culture->read(null, $id);
		}
		$experiments = $this->Culture->Experiment->find('list');
		$this->set(compact('experiments'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for culture', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Culture->delete($id)) {
			$this->Session->setFlash(__('Culture deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Culture was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>