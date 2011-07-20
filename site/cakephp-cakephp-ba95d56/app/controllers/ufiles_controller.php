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
            }
            else {
                $this->Session->setFlash('ERROR: ' . $this->FileUpload->showErrors());
            }
        }
        $keywords = $this->Ufile->Keyword->find('list');
        $this->set(compact('keywords'));
    }

	function index() {
		$this->Ufile->recursive = 0;
		$this->set('ufiles', $this->paginate());
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
