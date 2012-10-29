<?php
class SamplePlantsController extends AppController {

	var $name = 'SamplePlants';

	function index() {
		$this->SamplePlant->recursive = 0;
		$this->set('samplePlants', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sample plant', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('samplePlant', $this->SamplePlant->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->SamplePlant->create();
			if ($this->SamplePlant->save($this->data)) {
				$this->Session->setFlash(__('The sample plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sample plant could not be saved. Please, try again.', true));
			}
		}
		$samples = $this->SamplePlant->Sample->find('list');
		$plants = $this->SamplePlant->Plant->find('list');
		$this->set(compact('samples', 'plants'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sample plant', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SamplePlant->save($this->data)) {
				$this->Session->setFlash(__('The sample plant has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sample plant could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SamplePlant->read(null, $id);
		}
		$samples = $this->SamplePlant->Sample->find('list');
		$plants = $this->SamplePlant->Plant->find('list');
		$this->set(compact('samples', 'plants'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sample plant', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SamplePlant->delete($id)) {
			$this->Session->setFlash(__('Sample plant deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Sample plant was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>