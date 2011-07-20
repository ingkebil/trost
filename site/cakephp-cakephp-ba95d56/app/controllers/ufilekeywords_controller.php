<?php
class UfilekeywordsController extends AppController {

	var $name = 'Ufilekeywords';

	function index() {
		$this->Ufilekeyword->recursive = 0;
		$this->set('ufilekeywords', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ufilekeyword', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ufilekeyword', $this->Ufilekeyword->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ufilekeyword->create();
			if ($this->Ufilekeyword->save($this->data)) {
				$this->Session->setFlash(__('The ufilekeyword has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ufilekeyword could not be saved. Please, try again.', true));
			}
		}
		$ufiles = $this->Ufilekeyword->Ufile->find('list');
		$keywords = $this->Ufilekeyword->Keyword->find('list');
		$this->set(compact('ufiles', 'keywords'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ufilekeyword', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ufilekeyword->save($this->data)) {
				$this->Session->setFlash(__('The ufilekeyword has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ufilekeyword could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ufilekeyword->read(null, $id);
		}
		$ufiles = $this->Ufilekeyword->Ufile->find('list');
		$keywords = $this->Ufilekeyword->Keyword->find('list');
		$this->set(compact('ufiles', 'keywords'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ufilekeyword', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ufilekeyword->delete($id)) {
			$this->Session->setFlash(__('Ufilekeyword deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ufilekeyword was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>