<?php
class TempsController extends AppController {

	var $name = 'Temps';
    var $helpers = array('Ajax');

	function index() {
		$this->Temp->recursive = 0;
		$this->set('temps', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid temp', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('temp', $this->Temp->read(null, $id));
	}

	function erature() {
		if (!empty($this->data)) {
			$this->Temp->create();
            # make the entered temperaturs from European to American notation (comma to dot)
            # for getting it out of the DB with a comma again, this is done in the views :/
            $this->data['Temp']['tmin'] = str_replace(',', '.', $this->data['Temp']['tmin']);
            $this->data['Temp']['tmax'] = str_replace(',', '.', $this->data['Temp']['tmax']);
			if ($this->Temp->save($this->data)) {
				$this->Session->setFlash(__('The temp has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp could not be saved. Please, try again.', true));
			}
		}
        $this->set('locations', $this->Temp->Location->find('list'));
        $this->data['Temp']['location_id'] = $this->Auth->user('location_id');
	}

    function invalidate($id = null) {
        if (!$this->RequestHandler->isAjax()) { # if no AJAX, it might be just a crawler
            $this->redirect('/', 500);
        }
        if (!$id) {
            $this->Session->setFlash(__('Invalid Temperature', true));
            $this->redirect(array('action' => 'index'));
        }
        $temp = $this->Temp->read(null, $id);
        $temp['Temp']['invalid'] = $temp['Temp']['invalid'] == 1 ? 0 : 1;
        pr($temp);
        if ($this->Temp->save($temp)) {
        } else {
            $this->redirect('/', 500);
        }
    }
    function duplicates() {
        $this->paginate = array(
            'conditions' => array(
                # these AND/OR statements don't seem to work
                #'AND' => array(
                #    'OR' => array('Temp.invalid' => 0, 'Temp.invalid' => null),
                #    'OR' => array('Temp2.invalid' => 0, 'Temp2.invalid' => null),
                #),
                'Temp.id != Temp2.id',
            ),
            'joins' => array(
                array(
                    'table' => 'temps',
                    'alias' => 'Temp2',
                    'type'  => 'inner',
                    'conditions' => array(
                        'Temp.datum = Temp2.datum',
                        'Temp.location_id = Temp2.location_id'
                    )
                )
            ),
            'order' => array('Location.id', 'Temp.datum', 'Temp2.datum')
        );
        $this->set('temps', $this->paginate());
    }
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid temp', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Temp->save($this->data)) {
				$this->Session->setFlash(__('The temp has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The temp could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Temp->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for temp', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Temp->delete($id)) {
			$this->Session->setFlash(__('Temp deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Temp was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
