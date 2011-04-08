<?php
class ValuesController extends AppController {

	var $name = 'Values';

    function upload() {
		if (!empty($this->data)) {
            $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
            $lines = explode("\n", $raw);
            $this->Value->begin();
            $saved = true;
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line) {
                    $line_parts = explode(';', $line);
                    foreach ($line_parts as &$line_part) {
                        $line_part = preg_replace('/^"|"$/', '', $line_part);
                    }
                    list($id, $attribute, $value, $attr_dt, $val_dt) = $line_parts;
                    $this->Value->locale = 'en_us';
                    $this->Value->create();
                    if ($this->Value->save(array('Value' => compact('id', 'attribute', 'value')))) {
                        # now save in German
                        $this->Value->locale = 'de_de';
                        $this->Value->create();
                        if ($attr_dt) {
                            $attribute = $attr_dt;
                        }
                        if ($val_dt) {
                            $value = $val_dt;
                        }
                        if ( ! $this->Value->save(array('Value' => compact('id', 'attribute', 'value')))) {
                            $saved = false;
                            break;
                        }
                    } else {
                        $saved = false;
                        break;
                    }
                }
            }
            if ($saved) {
                $this->Session->setFlash(__('The values have been saved', true));
                $this->Value->commit();
                #$this->redirect(array('action' => 'index'));
            }
            else {
                $this->Value->rollback();
                $this->Session->setFlash(__('The values could not be saved. Please, try again.', true));
            }
		}
    }

	function index() {
		$this->Value->recursive = 0;
		$this->set('values', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid value', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('value', $this->Value->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Value->create();
			if ($this->Value->save($this->data)) {
				$this->Session->setFlash(__('The value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value could not be saved. Please, try again.', true));
			}
		}
		$phenotypes = $this->Value->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid value', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Value->save($this->data)) {
				$this->Session->setFlash(__('The value has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The value could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Value->read(null, $id);
		}
		$phenotypes = $this->Value->Phenotype->find('list');
		$this->set(compact('phenotypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for value', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Value->delete($id)) {
			$this->Session->setFlash(__('Value deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Value was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
