<?php
class PlantsController extends AppController {

	var $name = 'Plants';

	function index() {
		$this->Plant->recursive = 0;
		$this->set('plants', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid plant', true));
			$this->redirect(array('action' => 'index'));
		}
		#$this->set('plant', $this->Plant->read(null, $id));
        $this->set('plant', $this->Plant->find('first', array(
            'conditions' => array('Plant.id' => $id),
            'contain' => array('Sample', 'Culture', 'Subspecies', 'Phenotype', 'Phenotype.Program', 'Phenotype.Entity', 'Phenotype.Value', 'Phenotype.Bbch')
        )));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Plant->create();
			if ($this->Plant->save($this->data)) {
				$this->Session->setFlash(__('The plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plant could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid plant', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Plant->save($this->data)) {
				$this->Session->setFlash(__('The plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The plant could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Plant->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for plant', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Plant->delete($id)) {
			$this->Session->setFlash(__('Plant deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Plant was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
