<?php

class UfilesController extends AppController {

 	var $name = 'Ufiles';
    var $helpers = array('Html', 'Form', 'FileUpload.FileUpload');
    var $components = array('FileUpload.FileUpload');
    var $uses = array('Ufile', 'Location', 'Keyword');


    function beforeFilter() {
        parent::beforeFilter();

        # some settings for the automatic upload handling
        # change the upload dir when we actually are uploading something
        if ($this->action == 'upload' && ! empty($this->data)) {
            $person = $this->Session->read('Auth.Person');
            $this->FileUpload->uploadDir(Configure::read('FileUpload.uploadDir') . $person['name'] . $person['id']);
        }
        else {
            $this->FileUpload->uploadDir(Configure::read('FileUpload.uploadDir'));
        }
        $this->FileUpload->forceWebroot(false);
        $this->FileUpload->fileModel(null);
        $this->FileUpload->allowedTypes(array(
            '*' // allow all
#            'jpg' => array('image/jpeg', 'image/pjpeg'), //validate only image/jpeg and image/pjpeg mime types with ext .jpg
#            'png' => array('image/png'),                 //validate only image/png mime type file with ext .png
#            'gif',                                       //validate all MIME types for ext .gif
#            'swf',                                       //validate all MIME types for ext .swf 
#            'pdf' => array('application/pdf'),           //validate only application/pdf mime type for ext .pdf
        ));
    }

    function upload() {
        if (! empty($this->data)) {
            # first add the newly entered kw's
            $new_kw_ids = $this->__add_keywords($this->data['Ufile']['new_keywords']);
            # add the new kw_id's to the KwKw array
            if (empty($this->data['Keyword']['Keyword'])) {
                $this->data['Keyword']['Keyword'] = array();
            }
            $this->data['Keyword']['Keyword'] = array_unique(array_merge($this->data['Keyword']['Keyword'], $new_kw_ids)); # add unique check in case someone added a new existing keyword and selected it as well
            # add the user id of the logged in user
            $person = $this->Session->read('Auth.Person');
            $this->data['Ufile']['person_id'] = $person['id'];
            if ($this->Ufile->validates($this->data)) {
                if ($this->FileUpload->success) {
                    $success = true;
                    foreach ($this->FileUpload->uploadedFiles as $uploaded_file) {
                        if ($uploaded_file['name'] && ! $uploaded_file['error']) {
                            $this->Ufile->create();
                            $this->data['Ufile']['name'] = $uploaded_file['name'];

                            if (! $this->Ufile->save($this->data)) {
                                $success = false;
                                $this->Session->setFlash(
                                    __('One or more files could not be saved.', true) .
                                   ' ' . $this->FileUpload->showErrors()
                                );
                                break;
                            }
                        }
                    }
                    if ($success) {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash('ERROR: ' . $this->FileUpload->showErrors());
                }
            }
        }
        # http://forums.mysql.com/read.php?10,225465,225545#msg-225545
        $keywords  = $this->Ufile->Keyword->find('list', array('order' => array('cast(name as char)' => 'ASC', 'binary name' => 'DESC')));
        $this->set(compact('keywords'));
    }

    function __add_keywords($kw) {
        $keywords = explode(',', $kw);
        $keywords = array_map('trim', $keywords);

        $saved = true;
        $keyword_ids = array();
        foreach ($keywords as $keyword) {
            if (empty($keyword)) continue;
            # look up the keyword in case it exists already
            $first_match = $this->Keyword->find('first', array('conditions' => array('name' => $keyword)));
            if (empty($first_match)) {
                $this->Keyword->locale = str_replace('-', '_', Configure::read('Config.language'));
                $this->Keyword->create();
                if (! $this->Keyword->save(array('Keyword' => array('name' => $keyword)))) {
                    $saved = false;
                    continue;
                }
                $keyword_ids[] = $this->Keyword->id;
            }
            else {
                $keyword_ids[] = $first_match['Keyword']['id'];
            }
        }

        return $keyword_ids;
    }

    /**
     * post-to-get search: post the search question, and redirect to a results page with the question asked in the querystring
     */
    function search() {
        unset($this->Ufile->validate['submitter']); # remove a specific validtion rule only for this action
        unset($this->Ufile->validate['name']); # remove a specific validtion rule only for this action
        
        if ($this->data) {
            # do some whitelisting
            $whitelist = array('person_id', 'name', 'description');
            $passed_values = array();
            foreach ($this->data['Ufile'] as $key => $value) {
                if (in_array($key, $whitelist)) {
                    $passed_values[$key] = $value;
                }
            }

            # handle the keywords
            $keywords = $this->Ufile->Keyword->find('list', array('conditions' => array('Keyword.id' => $this->data['Keyword']['Keyword'])));
            if (! empty($keywords)) {
                $passed_values['keyword'] = implode(';', $keywords);
            }
            if (! empty($passed_values)) {
                $this->redirect(array_merge(array('action' => 'results'), $passed_values));
            }
        }
        else {
            $keywords = $this->Ufile->Keyword->find('list');
            $person = $this->Ufile->Person->find('all', array('fields' => array('Person.id', 'Person.name', 'Location.name'), 'contain' => array('Location'))); # get all people with their locations
            $people = Set::combine($person, '{n}.Person.id', '{n}.Person.name', '{n}.Location.name'); # reformat the array so it's grouped on locations
            $this->set(compact('keywords', 'people'));
        }
    }

    function results() {
        # TODO whitelist params

        $keywords = @$this->params['named']['keyword'];
        unset($this->params['named']['keyword']);

        pr($keywords);
        $keyword_ids = $this->Ufile->Keyword->find('list', array(
            'fields' => array('id', 'id'),
            'conditions' => array('name' => array_unique(explode(';', $keywords), SORT_STRING))
        ));
        pr($keyword_ids);
        $conditions = $this->params['named'];
        if (!empty($keyword_ids)) {
            foreach (array_unique($keyword_ids, SORT_NUMERIC) as $keyword_id) {
                $conditions[] = array('Ufilekeyword.keyword_id' => $keyword_id);
            }
            #$conditions = am($conditions, array('Ufilekeyword.keyword_id' => array_unique($keyword_ids, SORT_NUMERIC)));
        }

        # this query will not get all the keywords for the files selected, so only use this to get the ufile_id
        $this->Ufile->bindModel(array('hasOne' => array('Ufilekeyword')), false);
        $ufile_ids = $this->Ufile->find('all', array(
            'contain' => array('Ufilekeyword'),
            'conditions' => $conditions,
        ));
        $ufile_ids = Set::extract('/Ufile/id', $ufile_ids);

        $this->paginate['Ufile'] = array(
            'group' => array('Ufile.id'),
            'contain' => array('Keyword', 'Person'),
            'conditions' => array('Ufile.id' => array_unique($ufile_ids, SORT_NUMERIC)),
        );
        $this->set('ufiles', $this->paginate('Ufile'));
    }

	function index() {
        $this->paginate['Ufile'] = array(
            'contain' => array('Keyword', 'Person', 'Person.Location'),
        );
		$this->set('ufiles', $this->paginate('Ufile'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ufile', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('ufile', $this->Ufile->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ufile->create();
			if ($this->Ufile->save($this->data)) {
				$this->Session->setFlash(__('The ufile has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ufile could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ufile', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ufile->save($this->data)) {
				$this->Session->setFlash(__('The ufile has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ufile could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ufile->read(null, $id);
		}
        $keywords = $this->Ufile->Keyword->find('list');
        $this->set(compact('keywords'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ufile', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ufile->delete($id)) {
			$this->Session->setFlash(__('Ufile deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ufile was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
