<?php
class PeopleController extends AppController {

	var $name = 'People';

    function beforeFilter() {
        parent::beforeFilter();
    }

	function index() {
		$this->Person->recursive = 0;
		$this->set('people', $this->paginate());
	}

    function login() {
        $this->Auth->login();
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid person', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('person', $this->Person->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Person->create();
			if ($this->Person->save($this->data)) {
				$this->Session->setFlash(__('The person has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.', true));
			}
		}
		$locations = $this->Person->Location->find('list');
		$this->set(compact('locations'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid person', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Person->save($this->data)) {
				$this->Session->setFlash(__('The person has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Person->read(null, $id);
		}
		$locations = $this->Person->Location->find('list');
		$this->set(compact('locations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for person', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Person->delete($id)) {
			$this->Session->setFlash(__('Person deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Person was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
