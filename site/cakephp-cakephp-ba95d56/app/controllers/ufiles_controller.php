<?php

class UfilesController extends AppController {

 	var $name = 'Ufiles';
    var $helpers = array('Html', 'Form', 'FileUpload.FileUpload');
    var $components = array('FileUpload.FileUpload');

    function beforeFilter() {
        parent::beforeFilter();

        # some settings for the automatic upload handling
        $this->FileUpload->uploadDir(Configure::read('FileUpload.uploadDir'));
        if (! empty($this->data)) {
            $this->FileUpload->uploadDir(Configure::read('FileUpload.uploadDir') . $this->data['Ufile']['submitter']);
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
        $keywords = $this->Ufile->Keyword->find('list');
        $this->set(compact('keywords'));
    }

    /**
     * post-to-get search: post the search question, and redirect to a results page with the question asked in the querystring
     */
    function search() {
        unset($this->Ufile->validate['submitter']); # remove a specific validtion rule only for this action
        unset($this->Ufile->validate['name']); # remove a specific validtion rule only for this action
        
        if ($this->data) {
            # do some whitelisting
            $whitelist = array('submitter', 'name', 'description');
            $passed_values = array();
            foreach ($this->data['Ufile'] as $key => $value) {
                if (in_array($key, $whitelist)) {
                    $passed_values[$key] = $value;
                }
            }

            # handle the keywords
            $keywords = $this->Ufile->Keyword->find('list', array('conditions' => array('id' => $this->data['Keyword']['Keyword'])));
            if (! empty($keywords)) {
                $passed_values['keyword'] = implode(';', $keywords);
            }
            if (! empty($passed_values)) {
                $this->redirect(array_merge(array('action' => 'results'), $passed_values));
            }
        }
        else {
            $keywords = $this->Ufile->Keyword->find('list');
            $this->set(compact('keywords'));
        }
    }

    function results() {
        # TODO whitelist params

        $keywords = @$this->params['named']['keyword'];
        unset($this->params['named']['keyword']);

        $keyword_ids = $this->Ufile->Keyword->find('list', array(
            'fields' => array('id', 'id'),
            'conditions' => array('name' => array_unique(explode(';', $keywords), SORT_STRING))
        ));

        # this query will not get all the keywords for the files selected, so only use this to get the ufile_id
        $this->Ufile->bindModel(array('hasOne' => array('Ufilekeyword')), false);
        $ufile_ids = $this->Ufile->find('all', array(
            'contain' => array('Ufilekeyword'),
            'conditions' => array_merge($this->params['named'], array('Ufilekeyword.keyword_id' => $keyword_ids)),
        ));
        $ufile_ids = Set::extract('/Ufile/id', $ufile_ids);

        $this->paginate['Ufile'] = array(
            'group' => array('Ufile.id'),
            'contain' => array('Keyword'),
            'conditions' => array('Ufile.id' => $ufile_ids),
        );
        $this->set('ufiles', $this->paginate('Ufile'));
    }

	function index() {
        $this->paginate['Ufile'] = array(
            'contain' => array('Keyword'),
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
