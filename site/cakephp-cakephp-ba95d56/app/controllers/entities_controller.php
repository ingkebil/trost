<?php
class EntitiesController extends AppController {

	var $name = 'Entities';
    var $uses = array('Entity');

    function upload() {
		if (!empty($this->data)) {
            $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
            $lines = explode("\n", $raw);
            $this->Entity->begin();
            $saved = true;
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line) {
                    $line_parts = explode(';', $line);
                    foreach ($line_parts as &$line_part) {
                        $line_part = preg_replace('/^"|"$/', '', $line_part);
                    }
                    list($id, $name, $name_dt, $one, $two, $three, $four, $PO, $definition) = $line_parts;
                    $this->Entity->create();
                    if ($this->Entity->save(array('Entity' => compact('id', 'name', 'PO', 'definition')))) {
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
                $this->Session->setFlash(__('The entity has been saved', true));
                $this->Entity->commit();
                #$this->redirect(array('action' => 'index'));
            }
            else {
                $this->Entity->rollback();
                $this->Session->setFlash(__('The entity could not be saved. Please, try again.', true));
            }
		}
    }

	function index() {
		$this->Entity->recursive = 0;
		$this->set('entities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid entity', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('entity', $this->Entity->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Entity->create();
			if ($this->Entity->save($this->data)) {
				$this->Session->setFlash(__('The entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entity could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->Entity->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid entity', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Entity->save($this->data)) {
				$this->Session->setFlash(__('The entity has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The entity could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Entity->read(null, $id);
		}
		$phenotypes = $this->Entity->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for entity', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Entity->delete($id)) {
			$this->Session->setFlash(__('Entity deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Entity was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
