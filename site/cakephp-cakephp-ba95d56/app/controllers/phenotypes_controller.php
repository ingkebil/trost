<?php
class PhenotypesController extends AppController {

	var $name = 'Phenotypes';
    var $helpers = array('Html', 'Form', 'Ajax', 'Javascript');
    var $components = array('RequestHandler');

    function upload() {
		if (!empty($this->data)) {

            # init
            $program_id = $this->data['Phenotype']['program_id'];

            # check if manual input is needed, if yes, redirect to next view
            if ($this->data['File']['manual']) {
                $url['controller'] = '/'.$this->params['lang'].'/'.$this->params['controller'];
                $url['action'] = 'manualupload';
                $url['p'] = $program_id;
                $url['c'] = $this->data['Plant']['culture_id'];
                $url['e'] = $this->data['Culture']['experiment_id'];
                $this->redirect($url);
            }

            $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
            $lines = explode("\n", $raw);
            $line_nr = 1;

            $this->Phenotype->begin(); # start transaction # TODO maybe we should do a transaction per line and not per file

            # save the raw file
			$this->Phenotype->PhenotypeRaw->Raw->create();
            $raw = $this->Phenotype->PhenotypeRaw->Raw->save(array(
                'Raw' => array('data' => $raw)
            ));
            if (empty($raw)) {
                $this->Phenotype->rollback();
            }
            else {
                $raw_id = $this->Phenotype->PhenotypeRaw->Raw->getLastInsertID();
                $success = false;
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!$line) {
                        continue;
                    }
                    # GOD SAVE THE GENE!
                    $success = $this->_save_upload($line, $program_id, $raw_id, $line_nr);
                    if (! $success) {
                        break;
                    }
                    $line_nr++;
                }
                if ($success) {
                    $this->Phenotype->commit();
                    $this->Session->setFlash(__('The phenotype has been saved', true));
                }
                else {
                    $this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
                }
                #$this->Phenotype->create();
                #if ($this->Phenotype->save($this->data)) {
                #	$this->Session->setFlash(__('The phenotype has been saved', true));
                #	$this->redirect(array('action' => 'index'));
                #} else {
                #	$this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
                #}
            }
        }
		$programs = $this->Phenotype->Program->find('list');
        $programs[0] = 'autodetect';
        ksort($programs);
        $experiments = $this->Phenotype->Plant->Culture->Experiment->find('list');
#        $cultures = $this->Phenotype->Plant->Culture->find('list'); # fill them all, eventhough this should be filled dynamically after selecting an experiment
		$this->set(compact('programs', 'experiments'));
    }

    function _save_upload($line, $program_id, $raw_id = null, $line_nr = null) {
        #init
        $version = $object = $program = $entity_id = $attribute_id = $attribute_name = $attribute_state = $plant_id = $attribute_value = $date = $time = $bbch_id = $bbch_name = $entity_name = null;

        # split the line according to the program
        if ($program_id == 0) {
            list($version, $object, $program,) = explode(';', $line);

            if ($program == 'Fast Score') {
                $program_id = 1;
            }
            else {
                $program_id = 2;
            }
        }
        if ($program_id == 1) { # FastScore
            list($version, $object, $program, $entity_id, $attribute_id, $attribute_name, $attribute_state, $plant_id, $attribute_value, $date, $time) = explode(';', $line);
        }
        elseif ($program_id == 2) { # Phenotyping
            list($version, $object, $program, $plant_id, $bbch_id, $bbch_name, $date, $time, $entity_id, $enity_name, $attribute_id, $attribute_state, $attribute_value) = explode(';', $line);
        }

        # TODO maybe it could be easier to create the correct array to save instead of saving each model individually; Oh man, why again didn't I do this??

        # insert the plant info # TODO we prolly need to check if the plant exists in LIMS
        $plant = $this->Phenotype->Plant->find('first', array('conditions' => array('aliquot' => $plant_id)));
        if (empty($plant)) {
            $this->Phenotype->Plant->create();
            $plant = $this->Phenotype->Plant->save(array(
                'Plant' => array(
                    'aliquot' => $plant_id,
                    'culture_id' => $this->data['Plant']['culture_id'],
                    'sample_id' => 1,
                )
            ));
            if (empty($plant)) {
                $this->Phenotype->rollback();
                return false;
            }
            $plant['Plant']['id'] = $this->Phenotype->Plant->getLastInsertID();
        }

        # save the phenotyping info
        $this->Phenotype->create();
        $phenotype = $this->Phenotype->save(array(
            'Phenotype' => array_merge(
                compact('version', 'object', 'program_id', 'date', 'time'),
                array('plant_id' => $plant['Plant']['id'])
            )
        ));
        if (empty($phenotype)) {
            $this->Phenotype->rollback();
            return false;
        }

        if ($raw_id) {
            # connect this line with the raw file
            $this->Phenotype->PhenotypeRaw->create();
            $ph_raw = $this->Phenotype->PhenotypeRaw->save(array(
                'PhenotypeRaw' => array(
                    'raw_id' => $raw_id,
                    'phenotype_id' => $this->Phenotype->getLastInsertID(),
                    'line_nr' => $line_nr,
                )
            ));
        }

        # save the entity info # TODO check if entity ID exists and matches!
        $this->Phenotype->PhenotypeEntity->create();
        $ph_entity = $this->Phenotype->PhenotypeEntity->save(array(
            'PhenotypeEntity' => array(
                'phenotype_id' => $this->Phenotype->getLastInsertID(),
                'entity_id' => $entity_id
            )
        ));

        # save the attribute info # TODO check if attribute ID exists and matches!
        $this->Phenotype->PhenotypeValue->create();
        $ph_attribute = $this->Phenotype->PhenotypeValue->save(array(
            'PhenotypeValue' => array(
                'phenotype_id' => $this->Phenotype->getLastInsertID(),
                'value_id' => $attribute_id,
                'number' => $attribute_value
            )
        ));

        # save the BBCH info # TODO check if BBCH ID exists and matches!
        if ($bbch_id !== null) {
            $this->Phenotype->PhenotypeBbch->Bbch->create();
            $ph_entity = $this->Phenotype->PhenotypeBbch->Bbch->save(array(
                'Bbch' => array(
                    'phenotype_id' => $this->Phenotype->getLastInsertID(),
                    'bbch_id' => $bbch_id
                )
            ));
        }

        return $this->Phenotype->getLastInsertID();
    }

    function get_cultures() {
        $this->set('options',
            $this->Phenotype->Plant->Culture->find('list',
                array('conditions' => array(
                    'Culture.experiment_id' => $this->data['Culture']['experiment_id'])
                )
            )
        );
        $this->render('/phenotypes/get_cultures');
    }

    function _save_manualupload($program_id) {
        $line = '';
        pr($this->data);
        if ($program_id == 1) {
            $line .= $this->data['Phenotype']['version'];
            $line .= ';'. $this->data['Phenotype']['object'];
            $line .= ';Fast Score';
            $line .= ';'. $this->data['PhenotypeEntity']['entity_id'];
            $line .= ';'. $this->data['PhenotypeValue']['value_id'];
            $line .= ';'. $this->data['Value']['attribute'];
            $line .= ';'. $this->data['Value']['value'];
            $line .= ';'. $this->data['Plant']['aliquot'];
            $line .= ';'. $this->data['PhenotypeValue']['number'];
            $line .= ';'. $this->Phenotype->deconstruct('date', $this->data['Phenotype']['date']);
            $line .= ';'. $this->Phenotype->deconstruct('time', $this->data['Phenotype']['time']);
        }
        if ($program_id == 2) {
            $line .= $this->data['Phenotype']['version'];
            $line .= ';'. $this->data['Phenotype']['object'];
            $line .= ';Phenotyping';
            $line .= ';'. $this->data['Plant']['aliquot'];
            $line .= ';'. $this->data['PhenotypeBbch']['bbch'];
            $line .= ';'. $this->data['Bbch']['name'];
            $line .= ';'. $this->Phenotype->deconstruct('date', $this->data['Phenotype']['date']);
            $line .= ';'. $this->Phenotype->deconstruct('time', $this->data['Phenotype']['time']);
            $line .= ';'. $this->data['PhenotypeEntity']['entity_id'];
            $line .= ';'. $this->data['Entity']['name'];
            $line .= ';'. $this->data['PhenotypeValue']['value_id'];
            $line .= ';'. $this->data['Value']['attribute'];
            $line .= ';'. $this->data['Value']['value'];
            $line .= ';'. $this->data['PhenotypeValue']['number'];
        }
        return $this->_save_upload($line, $program_id);
    }

    function manualupload() {
        $program_id =    isset($this->params['named']['p']) ? $this->params['named']['p'] : @$this->data['Phenotype']['program_id'];
        $culture_id =    isset($this->params['named']['c']) ? $this->params['named']['c'] : @$this->data['Plant']['culture_id'];
        $experiment_id = isset($this->params['named']['e']) ? $this->params['named']['e'] : @$this->data['Culture']['experiment_id'];
        if (!empty($this->data) and isset($this->data['Form']['posted'])) {
            $this->Phenotype->begin();
            if ($phenotype_id = $this->_save_manualupload($program_id)) {
                $this->Session->setFlash(__('The phenotype has been saved.', true), 'flashedit', array('id' => $phenotype_id, 'controller' => $this->name, 'edit_message' => __('Edit?', true)), 'edit');
                $this->Phenotype->commit();
                if ($this->data['Form']['lastone'] == 1) {
                    $this->redirect(array('action'=>'index'));
                }
            }
            else {
                $this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
                $this->Phenotype->rollback();
            }

            unset($this->data['PhenotypeEntity']['entity_id']);
            unset($this->data['PhenotypeValue']['value_id']);
            unset($this->data['Value']['attribute']);
            unset($this->data['PhenotypeValue']['Number']);
            unset($this->data['Phenotype']['time']);
            unset($this->data['Form']['posted']);
        }

        $this->data['Phenotype']['program_id'] = $program_id;
        $this->data['Culture']['experiment_id'] = $experiment_id;
        $this->data['Plant']['culture_id'] = $experiment_id;

        # fill in some basics
        $this->set('entities_', $this->Phenotype->PhenotypeEntity->Entity->find('list'));
        $this->set('values_', $this->Phenotype->PhenotypeValue->Value->find('list', array('fields' => array('id', 'value'))));
        $this->set('attributes_', $this->Phenotype->PhenotypeValue->Value->find('list', array('fields' => array('id', 'attribute'))));
        if ($program_id == 2) {
            $this->set('bbchs_', $this->Phenotype->PhenotypeBbch->Bbch->find('list'));
        }

    }

    function uploadlastone() {
        $program_id = isset($this->params['named']['p']) ? $this->params['named']['p'] : @$this->data['Phenotype']['program_id'];
        pr($program_id);
        pr($this->data);
        if ($this->_save_manualupload($program_id)) {
            $this->Session->setFlash(__('The phenotype has been saved.', true), 'flashedit', array('id' => $phenotype_id, 'controller' => $this->name, 'edit_message' => __('Edit?', true)), 'edit');
            $this->redirect(array('action'=>'index'));
        }
        else {
            $this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
            unset($this->data['Form']['posted']);
            $this->action = 'manualupload';
        }
    }

	function index() {
		$this->Phenotype->recursive = 0;
		$this->set('phenotypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('phenotype', $this->Phenotype->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Phenotype->create();
			if ($this->Phenotype->save($this->data)) {
				$this->Session->setFlash(__('The phenotype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
			}
		}
		$programs = $this->Phenotype->Program->find('list');
		$plants = $this->Phenotype->Plant->find('list');
		$this->set(compact('programs', 'plants'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Phenotype->save($this->data)) {
				$this->Session->setFlash(__('The phenotype has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Phenotype->read(null, $id);
		}
		$programs = $this->Phenotype->Program->find('list');
		$plants = $this->Phenotype->Plant->find('list');
		$this->set(compact('programs', 'plants'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phenotype', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Phenotype->delete($id)) {
			$this->Session->setFlash(__('Phenotype deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phenotype was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
