<?php
class BbchesController extends AppController {

	var $name = 'Bbches';

    function upload() {
		if (!empty($this->data)) {
            $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
            $species_id = $this->data['Bbch']['species_id'];
            $lines = explode("\n", $raw);
            $this->Bbch->begin();
            $saved = true;
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line) {
                    $line_parts_all = explode(';', $line);
                    $line_parts = array($line_parts_all[0], $line_parts_all[8]);
                    foreach ($line_parts as &$line_part) {
                        $line_part = preg_replace('/^"|"$/', '', $line_part);
                    }
                    list($bbch, $name) = $line_parts;
                    # check if we already have one with the combination of bbch and species_id
                    $bbch_uniq = $this->Bbch->find('first', array('conditions' => compact('name', 'bbch'), 'contain' => false));
                    if (!empty($bbch_uniq)) {
                        $id = $bbch_uniq['Bbch']['id'];
                    }
                    else {
                        $this->Bbch->create();
                    }
                    if ($this->Bbch->save(array('Bbch' => compact('id', 'bbch', 'name', 'species_id')))) {
                        # look up if this entry exists as German
                        # TODO add i18n
                        #$i18n = $this->
                    } else {
                        $saved = false;
                        break;
                    }
                }
            }
            if ($saved) {
                $this->Session->setFlash(__('The BBCH codes have been saved', true));
                $this->Bbch->commit();
                #$this->redirect(array('action' => 'index'));
            }
            else {
                $this->Bbch->rollback();
                $this->Session->setFlash(__('The BBCH codes could not be saved. Please, try again.', true));
            }
		}
        $this->set('species', $this->Bbch->Species->find('list'));
    }

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
