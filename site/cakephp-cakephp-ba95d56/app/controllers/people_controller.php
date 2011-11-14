<?php
class PeopleController extends AppController {

	var $name = 'People';
    var $helpers = array('Html', 'Form');

    function beforeFilter() {
        parent::beforeFilter();
        #$this->Auth->allow('add', 'edit');

        if ($this->action == 'add' || $this->action == 'edit') {
            $this->Auth->authenticate = $this->Person;
        }
    }

	function index() {
		$this->Person->recursive = 0;
		$this->set('people', $this->paginate());
	}

    function login() {
        $this->Auth->login();
    }

    function logout() {
        $this->Auth->logout();
        $this->redirect('/');
    }

    /**
     * Expects a file with on each line following information:
     * - prolly an ID, but first column is ignored
     * - username (login)
     * - name (display name)
     * - email (location will be based on on the domain of the email)
     * - password, and if empty, will be default
     */
    function upload() {
        if (! empty($this->data)) {
            $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
            $raw = mb_convert_encoding($raw, 'UTF-8', mb_detect_encoding($raw));
            $lines = explode("\n", $raw);
            $line_nr = 1;

            $this->Person->begin();
            $success = true;
            foreach ($lines as $line) {
                $line = trim($line);
                if (!$line) { # skip empty lines
                    continue;
                }
                $line_parts = explode("\t", $line);
                foreach ($line_parts as &$item) {
                    $item = preg_replace('/^"|"$/', '', $item);
                }
                list($id, $name, $username, $email) = $line_parts;
                list(,$domain) = explode('@', $email);

                $location = $this->Person->Location->find('first', array(
                    'conditions' => array('name' => $domain),
                ));
                if (empty($location)) {
                    $this->Person->Location->create();
                    if (!$this->Person->Location->save(array(
                        'Location' => array('name' => $domain)
                    ))) {
                        $this->Person->rollback();
                        $this->Session->setFlash("Could not find location on line #$line_nr: '$line'");
                        $success = false;
                        break;
                    }
                    $location_id = $this->Person->Location->getLastInsertID();
                }
                else {
                    $location_id = $location['Location']['id'];
                }

                $password = Configure::read('default.password');
                $password_confirm = $password; # make sure the validation actually works
                $this->Person->create();
                if (! $this->Person->save(array(
                    'Person' => compact('location_id', 'name', 'username', 'password', 'password_confirm'),
                ))) {
                    $this->Person->rollback();
                    $this->Session->setFlash("Could not save person on line #$line_nr: '$line'".pr(compact('location_id', 'name', 'username', 'password', 'password_confirm'), true));
                    $success = false;
                    break;
                }
                $line_nr++;
            }
            if ($success) {
                $this->Person->commit();
            }
        }
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
        $roles = array('admin' => 'admin', 'normal' => 'normal');
		$this->set(compact('locations', 'roles'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid person', true));
			$this->redirect('/');
		}
		if (!empty($this->data)) {
            if (empty($this->data['Person']['password'])) {
                unset($this->data['Person']['password']);
            }
			if ($this->Person->save($this->data)) {
				$this->Session->setFlash(__('The person has been saved', true));
				$this->redirect('/');
			} else {
				$this->Session->setFlash(__('The person could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Person->read(null, $id);
		}
		$locations = $this->Person->Location->find('list');
        $roles = array('admin' => 'admin', 'normal' => 'normal');
		$this->set(compact('locations', 'roles'));
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
