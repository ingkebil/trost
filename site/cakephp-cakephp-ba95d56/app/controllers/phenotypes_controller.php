<?php
class PhenotypesController extends AppController {

	var $name = 'Phenotypes';
    var $helpers = array('Html', 'Form', 'Ajax', 'Javascript');
    var $components = array('RequestHandler');
    var $uses = array('Phenotype', 'Plant', 'Culture', 'Experiment', 'Study', 'Value');

    function upload() {
		if (!empty($this->data)) {

            # init
            $program_id = $this->data['Phenotype']['program_id'];

            # check if manual input is needed, if yes, redirect to next view
            if ($this->data['File']['manual']) {
                $this->Phenotype->set($this->data);
                $this->Culture->set($this->data);
                if ($this->Phenotype->validates() and $this->Culture->validates()) {
                    $url['controller'] = $this->params['controller'];
                    $url['action'] = 'manualupload';
                    $url['p'] = $program_id;
                    $url['c'] = $this->data['Plant']['culture_id'];
                    $url['e'] = $this->data['Culture']['experiment_id'];
                    $this->redirect($url);
                }
            }
            else {
                if ($this->data['File']['raw']['error']) { # as we cannot validate this field, give an error when it's non-existing
                    $this->Session->setFlash(__('Please select a file to upload!', true));
                }
                else {
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
                            $this->redirect(array('controller' => 'raws', 'action' => 'view', $this->Phenotype->PhenotypeRaw->Raw->getLastInsertID()));
                        }
                        else {
                            $this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
                        }
                    }
                }
            }
        }
		$programs = $this->Phenotype->Program->find('list');
        $programs[0] = 'autodetect';
        ksort($programs);
        $experiments = $this->Experiment->find('list'); # actually, leave this out as it is not necesary right now.
        $this->_get_cultures(); # check the LIMS to add the right amount of cultures ;)
        $cultures = $this->Culture->find('list'); # fill them all, eventhough this should be filled dynamically after selecting an experiment
		$this->set(compact('programs', 'experiments', 'cultures'));
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
            list($version, $object, $program, $plant_id, $bbch_id, $bbch_name, $date, $time, $entity_id, $enity_name, $attribute_id, $attribute_state, $attribute_value, $attribute_number) = explode(';', $line);
        }
        if (strpos($date, '/')) {
            $date = join('-', array_reverse(explode('/', $date)));
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
                    'sample_id' => 1, # TODO remove this hardcoded value
                )
            ));
            if (empty($plant)) {
                $this->Phenotype->rollback();
                return false;
            }
            $plant['Plant']['id'] = $this->Phenotype->Plant->getLastInsertID();
        }
        #else {
        #    $this->Phenotype->rollback();
        #    return false;
        #}

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
            if( ! ($ph_raw = $this->Phenotype->PhenotypeRaw->save(array(
                'PhenotypeRaw' => array(
                    'raw_id' => $raw_id,
                    'phenotype_id' => $this->Phenotype->getLastInsertID(),
                    'line_nr' => $line_nr,
                )
            )))) {
                $this->Phenotype->rollback();
                return false;
            }
        }

        # save the entity info # TODO check if entity ID exists and matches!
        $this->Phenotype->PhenotypeEntity->create();
        if (! ($ph_entity = $this->Phenotype->PhenotypeEntity->save(array(
            'PhenotypeEntity' => array(
                'phenotype_id' => $this->Phenotype->getLastInsertID(),
                'entity_id' => $entity_id
            )
        )))) {
            $this->Phenotype->rollback();
            return false;
        }

        # save the attribute info # TODO check if attribute ID exists and matches!
        $this->Phenotype->PhenotypeValue->create();
        $attribute_number = isset($attribute_number) ? $attribute_number : null;
        if (! ($ph_attribute = $this->Phenotype->PhenotypeValue->save(array(
            'PhenotypeValue' => array(
                'phenotype_id' => $this->Phenotype->getLastInsertID(),
                'value_id' => $attribute_id,
                'number' => $attribute_number
            )
        )))) {
            $this->Phenotype->rollback();
            return false;
        }

        # save the BBCH info # TODO check if BBCH ID exists and matches!
        if ($program_id != 1) { # only add it if we have a bbch_code
            # look the right code up (as bbch_id != bbch.id)
            $bbch = $this->Phenotype->PhenotypeBbch->Bbch->find('first', array('conditions' => array('bbch' => $bbch_id)));
            if ( ! empty($bbch)) {
                $this->Phenotype->PhenotypeBbch->create();
                $ph_bbch = $this->Phenotype->PhenotypeBbch->save(array(
                    'PhenotypeBbch' => array(
                        'phenotype_id' => $this->Phenotype->getLastInsertID(),
                        'bbch_id' => $bbch['Bbch']['id'],
                    )
                ));
            }
        }

        return $this->Phenotype->getLastInsertID();
    }

    function _get_cultures() {
        $studies = $this->Study->find('list',
            array(
                'conditions' => array(
                    'status NOT' => 'X',
                    'study_type' => 'Culture',
                    'U_project' => 'TROST'
                ),
                'fields' => array(
                    'study_id',
                    'name'
                ),
            )
        );

        # now check if they need to be added to the internal system!
        foreach ($studies as $study_id => $name) {
            $culture = $this->Culture->find('first',
                array('conditions' => array(
                    'limsstudyid' => $study_id
                ))
            );
            if (empty($culture)) {
                $this->Culture->create();
                $this->Culture->save(array(
                    'Culture' => array(
                        'limsstudyid' => $study_id,
                        'experiment_id' => 1, # TODO remove hardcoded experiment id
                        'name' => $name
                    )
                ));
            }
        }
    }

    function get_cultures() {
        $this->_get_cultures();

        # no need to check which experiment this is, there is only one
        $options = $this->Culture->find('list');

        $this->set('options', $options);
        $this->render('/phenotypes/get_cultures'); # be aware that this also is the layout of get_valuevalues()!
    }

    function get_valuevalues($id = null) {
        $id = $id ? $id : $this->data['Value']['attribute'];
        $id = mysql_real_escape_string($id);
        $locale = mysql_real_escape_string(str_replace('-', '_', Configure::read('Config.language')));
        #$this->Value->locale = str_replace('-', '_', Configure::read('Config.language'));
        ## find the 'attribute'
        #$attribute = $this->Value->find('first', array('conditions' => array(
        #    'Value.id' => $id
        #)));
        ## find all the attribute IDs
        #$ids = $this->Value->find('list', array(
        #    'conditions' => array('attribute' => $attribute['Value']['attribute']),
        #    'fields' => array('Value.id', 'Value.id'),
        #));
        ## find all values of those attribute IDs
        #$this->set('options', $this->Value->find('list', array(
        #    'conditions' => array('Value.id' => $ids),
        #    'fields' => array('Value.id', 'Value.value'),
        #)));
        $id_values = $this->Value->query("
SELECT Value.id, i18n2.content FROM `values` Value
JOIN i18n ON (i18n.foreign_key = Value.id AND i18n.model = 'Value')
JOIN i18n i18n2 ON (i18n2.foreign_key = Value.id AND i18n2.model = 'Value')
WHERE i18n.content = '$id'
AND i18n2.field = 'value'
AND i18n2.locale = '$locale'
        ");
        $options = array();
        foreach ($id_values as $id_value) {
            $options[ $id_value['Value']['id'] ] = $id_value['i18n2']['content'];
        }
        $this->set(compact('options'));
        $this->render('/phenotypes/get_cultures');
    }

    function _save_manualupload($program_id) {
        $line = '';
        if ($program_id == 1) { # fastscore
            $line .= $this->data['Phenotype']['version'];
            $line .= ';'. $this->data['Phenotype']['object'];
            $line .= ';Fast Score';
            $line .= ';'. $this->data['PhenotypeEntity']['entity_id'];
            $line .= ';'. @$this->data['PhenotypeValue']['value_id'];
            $line .= ';'. $this->data['Value']['attribute'];
            $line .= ';'. @$this->data['Value']['value'];
            $line .= ';'. $this->data['Plant']['aliquot'];
            $line .= ';'. $this->data['PhenotypeValue']['number'];
            $line .= ';'. $this->Phenotype->deconstruct('date', $this->data['Phenotype']['date']);
            $line .= ';'. $this->Phenotype->deconstruct('time', $this->data['Phenotype']['time']);
        }
        if ($program_id == 2) { # phenotyping
            $line .= $this->data['Phenotype']['version'];
            $line .= ';'. $this->data['Phenotype']['object'];
            $line .= ';Phenotyping';
            $line .= ';'. $this->data['Plant']['aliquot'];
            $line .= ';'. $this->data['PhenotypeBbch']['bbch'];
            $line .= ';'. @$this->data['Bbch']['name'];
            $line .= ';'. $this->Phenotype->deconstruct('date', $this->data['Phenotype']['date']);
            $line .= ';'. $this->Phenotype->deconstruct('time', $this->data['Phenotype']['time']);
            $line .= ';'. $this->data['PhenotypeEntity']['entity_id'];
            $line .= ';'. @$this->data['Entity']['name'];
            $line .= ';'. $this->data['PhenotypeValue']['value_id'];
            $line .= ';'. $this->data['Value']['attribute'];
            $line .= ';'. @$this->data['Value']['value'];
            $line .= ';'. $this->data['PhenotypeValue']['number'];
        }

        $this->Phenotype->begin();
        $phenotype_id = $this->_save_upload($line, $program_id);
        if (!$phenotype_id) {
            $this->Phenotype->rollback();
            return false;
        }

        # now also save the RAW
        if ($this->data['PhenotypeRaw']['raw_id']) { # ow, we already saved it, so read it and append
            # read it in
            $raw = $this->Phenotype->PhenotypeRaw->Raw->read(null, $this->data['PhenotypeRaw']['raw_id']);
            # append
            $raw['Raw']['data'] .= "\n$line";
        }
        else {
            $raw['Raw']['data'] = $line;
        }
        if ($this->Phenotype->PhenotypeRaw->Raw->save($raw)) {
            $line_nr = 1;
            if (!empty($raw['PhenotypeRaw'])) {
                # first get the last line_nr by reverse sorting them (there actually is no reason why this shouldn't be just the last record in the PhenotypeRaw model of a certain Raw?)
                usort($raw['PhenotypeRaw'], create_function(
                    '$a,$b',
                    'if ($a["line_nr"] == $b["line_nr"]) { return 0; }
                    return $a["line_nr"] < $b["line_nr"] ? 1 : -1;'
                ));
                $line_nr = $raw['PhenotypeRaw'][0];
            }

            if (!isset($raw['Raw']['id'])) {
                $raw['Raw']['id'] = $this->Phenotype->PhenotypeRaw->Raw->getLastInsertID();
            }
        }

        if ($this->Phenotype->PhenotypeRaw->save(array('PhenotypeRaw' => array(
            'id' => null,
            'phenotype_id' => $phenotype_id,
            'raw_id' => $raw['Raw']['id'],
            'line_nr' => ++$line_nr,
        )))) {
            $this->data['PhenotypeRaw']['raw_id'] = $raw['Raw']['id'];
        }
        else {
            $this->Phenotype->rollback();
            return false;
        }
        $this->Phenotype->commit();

        return array($phenotype_id, $raw['Raw']['id']);
    }

    function manualupload() {
        $program_id =    isset($this->params['named']['p']) ? $this->params['named']['p'] : @$this->data['Phenotype']['program_id'];
        $culture_id =    isset($this->params['named']['c']) ? $this->params['named']['c'] : @$this->data['Plant']['culture_id'];
        $experiment_id = isset($this->params['named']['e']) ? $this->params['named']['e'] : @$this->data['Culture']['experiment_id'];
        $drop = isset($this->params['named']['drop']) ? $this->params['named']['drop'] : 1;

        # check the params
        if (! $program_id || ! $culture_id || ! $experiment_id ) {
            $this->Session->setFlash(__('Please select a program and a culture', true));
            $this->redirect(array('controller' => $this->name, 'action' => 'upload'));
        }

        # fill in the id in case we're editing this thing
        $id = isset($this->params['named']['id']) ? $this->params['named']['id'] : null; 
        if (!empty($this->data) and isset($this->data['Form']['posted'])) {
            $this->Phenotype->begin();
            if (list($phenotype_id, $raw_id) = $this->_save_manualupload($program_id)) {
                #$this->Session->setFlash(
                #    __('The phenotype has been saved.', true),
                #    'flashedit',
                #    array('id' => $phenotype_id, 'controller' => $this->name, 'action' => 'invalidate', 'edit_message' => __('Invalidate?', true)),
                #    'edit'
                #); # we don't really need the flash if we get a list of entered values already
                $this->Phenotype->commit();
                #unset($this->data['PhenotypeEntity']['entity_id']);
                #unset($this->data['PhenotypeValue']['value_id']);
                #unset($this->data['Value']['attribute']);
                unset($this->data['PhenotypeValue']['Number']);
                unset($this->data['Phenotype']['time']);
                unset($this->data['Form']['posted']);
                if ($this->data['Form']['lastone'] == 1) {
                    $this->redirect(array('controller' => 'raws', 'action'=>'view', $raw_id));
                }
                $this->set('phenotypes', $this->Phenotype->PhenotypeRaw->Raw->find('first', array('conditions' => array('id' => $raw_id), 'contain' => array('Phenotype.Plant', 'Phenotype.Entity', 'Phenotype.Value', 'Phenotype.Bbch'))));
                $this->set('lastinsertid', $phenotype_id);
            }
            else {
                $this->Session->setFlash(__('The phenotype could not be saved. Please, try again.', true));
                $this->Phenotype->rollback();
            }

        }
        elseif ($id) {
            $this->data = $this->Phenotype->read(null, $id);
            $this->data['PhenotypeEntity'] = $this->data['PhenotypeEntity'][0];
            $this->data['PhenotypeValue'] = $this->data['PhenotypeValue'][0];
        }

        $this->data['Phenotype']['program_id'] = $program_id;
        $this->data['Culture']['experiment_id'] = $experiment_id;
        $this->data['Plant']['culture_id'] = $culture_id;

        # fill in some basics
        $suffix = '_'; # add a suffix so the input fields don't get autofilled
        if ($drop) {
            $suffix = '';
            $this->set('drop', true);
        }
        else {
            $this->set('drop', false);
        }
        $this->set('entities'.$suffix, $this->Phenotype->PhenotypeEntity->Entity->find('list', array('fields' => array('id', 'name'))));
        #$this->set('values'.$suffix, $this->Phenotype->PhenotypeValue->Value->find('list', array('fields' => array('id', 'value'))));
        if ($drop) {
            $this->set('attributes'.$suffix, $this->Phenotype->PhenotypeValue->Value->find('list', array('fields' => array('attribute', 'attribute'))));
        }
        else {
            $this->set('attributes'.$suffix, $this->Phenotype->PhenotypeValue->Value->find('list', array('fields' => array('id', 'attribute'))));
        }
        if ($program_id == 2) { # load bbch codes when phenotyping program
            $this->set('bbchs'.$suffix, array_unique($this->Phenotype->PhenotypeBbch->Bbch->find('list')));
        }
    }

    function invalidate($id = null) {
        if (!$this->RequestHandler->isAjax()) { # if no AJAX, it might be just a crawler
            $this->redirect('/', 500);
        }
        if (!$id) {
            $this->Session->setFlash(__('Invalid phenotype', true));
            $this->redirect(array('action' => 'index'));
        }
        $phenotype = $this->Phenotype->read(null, $id);
        $phenotype['Phenotype']['invalid'] = $phenotype['Phenotype']['invalid'] == 1 ? 0 : 1;
        if ($this->Phenotype->save($phenotype)) {
        } else {
            $this->redirect('/', 500);
        }
    }
	function index() {
		$this->Phenotype->recursive = 1;
		$this->set('phenotypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		$phenotype = $this->Phenotype->read(null, $id);
		if ($phenotype['Phenotype']['invalid'] == 1) {
			$this->Session->setFlash(__('This entry has been marked as invalid!', true));
		}
		$this->set('phenotype', $phenotype);
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
		if (!$id) {
			$this->Session->setFlash(__('Invalid phenotype', true));
			$this->redirect(array('action' => 'index'));
		}
		$phenotype = $this->Phenotype->read(null, $id);
        $this->redirect(array(
            'action' => 'manualupload',
            'p' => $phenotype['Phenotype']['program_id'],
            'c' => $phenotype['Plant']['culture_id'],
            'e' => $phenotype['Culture']['experiment_id'],
            'id' => $phenotype['Phenotype']['id']
        ));
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
