<?php
class RawsController extends AppController {

	var $name = 'Raws';
    var $uses = array('Raw', 'PhenotypeRaw', 'Program');
    var $helpers = array('Javascript', 'Ajax');

	function index() {
		#$this->Raw->recursive = 2; # seems to go into an endless loop
        $this->paginate['Raw'] = array(
            'contain' => false
        );
        $this->Raw->cacheQueries = true;
        $raws = $this->paginate('Raw');

        # do some counts
        $dates = array(); # to get a date range
        foreach ($raws as &$raw) {
            $raw['Phenotype']['count']['bbch']   = $this->Raw->count_bbch($raw['Raw']['id']);
            $raw['Phenotype']['count']['lines'] = $this->Raw->count_lines($raw['Raw']['id']);
            $raw['Phenotype']['count']['value']  = $this->Raw->count_value($raw['Raw']['id']);
            $raw['Phenotype']['count']['entity'] = $this->Raw->count_entity($raw['Raw']['id']);
            $raw['Phenotype']['daterange'] = $this->Raw->find_phenotype_daterange($raw['Raw']['id']);
        }
        $this->set(compact('raws'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid raw', true));
			$this->redirect(array('action' => 'index'));
		}
        $this->set('programs', $this->Program->find('list'));
        $this->set('raw', $this->Raw->find('first', array('conditions' => array('id' => $id), 'contain' => array('Phenotype', 'Phenotype.Sample', 'Phenotype.Plant', 'Phenotype.Bbch', 'Phenotype.Entity', 'Phenotype.Value'))));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Raw->create();
			if ($this->Raw->save($this->data)) {
				$this->Session->setFlash(__('The raw has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The raw could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->Raw->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid raw', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Raw->save($this->data)) {
				$this->Session->setFlash(__('The raw has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The raw could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Raw->read(null, $id);
		}
		$phenotypes = $this->Raw->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for raw', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Raw->delete($id)) {
			$this->Session->setFlash(__('Raw deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Raw was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
