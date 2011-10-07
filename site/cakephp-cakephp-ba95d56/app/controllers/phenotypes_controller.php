<?php
class PhenotypesController extends AppController {

	var $name = 'Phenotypes';
    var $helpers = array('Html', 'Form', 'Ajax', 'Javascript');
    var $components = array('RequestHandler');
    var $uses = array('Phenotype', 'Plant', 'Culture', 'Experiment', 'Study', 'Value', 'Entity', 'Bbch');

    var $error_msg = false;

    function download() {
        if (! empty($this->data)) {
            $samples = $this->Phenotype->Sample->find('all', array(
                'conditions' => array(
                    'Sample.created BETWEEN ? AND ?' => array($this->data['Phenotype']['date_start'], $this->data['Phenotype']['date_end'])
                )
            ));

            $lines = array();
            foreach ($samples as $sample) {
                # version, object, program, entity id, value_id, attribute, value
                $line = array('Test220606', 'LIMS-Aliquot', 'Fast Score', 808, 178, 'component', 'component id');
                $line[] = $sample['Sample']['name'];
                $line[] = $sample['Plant']['name'];
                $datetime = explode(' ', $sample['Sample']['created']);
                $line[] = $datetime[0];
                $line[] = $datetime[1];
                $lines[] = implode("\t", $line);
            }
            $lines = implode("\n", $lines);
            $this->set(compact('lines'));
        }
    }

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
            else { # it's a file!
                if ($this->data['File']['raw']['error']) { # as we cannot validate this field, give an error when it's non-existing
                    $this->Session->setFlash(__('Please select a file to upload!', true));
                }
                else {
                    $raw = file_get_contents($this->data['File']['raw']['tmp_name']);
                    $raw = mb_convert_encoding($raw, 'UTF-8', mb_detect_encoding($raw));
                    $lines = explode("\n", $raw);
                    $line_nr = 1;

                    $this->Phenotype->begin(); # start transaction # TODO maybe we should do a transaction per line and not per file

                    # save the raw file
                    $this->Phenotype->PhenotypeRaw->Raw->create();
                    $raw = $this->Phenotype->PhenotypeRaw->Raw->save(array(
                        'Raw' => array(
                            'data' => $raw,
                            'filename' => $this->data['File']['raw']['name']
                        )
                    ));
                    if (empty($raw)) {
                        $this->Phenotype->rollback();
                    }
                    else {
                        $raw_id = $this->Phenotype->PhenotypeRaw->Raw->getLastInsertID();
                        $success = false;
                        foreach ($lines as $line) {
                            $line_nr++;
                            $line = trim($line);
                            if (!$line) {
                                continue;
                            }
                            list($program_id, $entity_id, $attribute_id) = $this->_preprocess_line($line, $program_id);
                            if ($program_id == 0) { # we don't know how to handle this
                                continue;
                            }
                            $is_sample_plant = $this->_is_sample_plant($entity_id, $attribute_id);

                            # and yes, we need to decide this on line level as sample/plant information can be intermixed with phenotyping information
                            $sp_success = true;
                            if ($is_sample_plant) {
                                # hopla, sample/plant information
                                $sp_success = $this->_save_sample_plant($line);
                            }

                            # GOD SAVE THE GENE!
                            $success = $this->_save_upload($line, $program_id, $raw_id, $line_nr);
                            if (! ($success && $sp_success)) {
                                break;
                            }
                        }
                        if ($success) {
                            $this->Phenotype->commit();
                            $this->Session->setFlash(__('The phenotype has been saved', true));
                            $this->redirect(array('controller' => 'raws', 'action' => 'view', $this->Phenotype->PhenotypeRaw->Raw->getLastInsertID()));
                        }
                        else {
                            $this->Session->setFlash(__('The phenotype could not be saved. Please, try again. ' . $this->error_msg, true));
                        }
                    }
                }
            }
        }
		$programs = $this->Phenotype->Program->find('list');
        $programs[0] = 'autodetect';
        ksort($programs);
        $experiments = $this->Experiment->find('list'); # actually, leave this out as it is not necesary right now.
        if ($_SERVER['SERVER_NAME'] == 'hal9000') { # there is a problem with the oracle driver on this machine, so skip this 
            $this->_get_cultures(); # check the LIMS to add the right amount of cultures ;)
        }
        $cultures = $this->Culture->find('list'); # fill them all, eventhough this should be filled dynamically after selecting an experiment
		$this->set(compact('programs', 'experiments', 'cultures'));
    }

    function _is_sample_plant($entity_id, $attribute_id) {
        return $entity_id == 808 && $attribute_id == 178;
    }

    function _save_sample_plant($line) {
        $line_parts = $this->_split_fastscore($line);
        # get/add the plant
        $plant = $this->Phenotype->Sample->Plant->find('first', array('conditions' => array(
            'aliquot' => $line_parts[8],
        )));
        if (empty($plant)) {
            $this->Phenotype->Sample->Plant->create();
            $plant = $this->Phenotype->Sample->Plant->save(array(
                'Plant' => array(
                    'aliquot' => $line_parts[8],
                    'culture_id' => $this->data['Plant']['culture_id']
                ),
            ));
            if (empty($plant)) {
                return false;
            }
            else {
                $plant['Plant']['id'] = $this->Phenotype->Sample->Plant->getLastInsertID();
            }
        }

        # get/add the sample
        $sample = $this->Phenotype->Sample->find('first', array('conditions' => array(
            'Sample.name' => $line_parts[7],
        )));
        if (empty($sample)) {
            $this->Phenotype->Sample->create();
        }

        # save/update the sample. It might be that the sample got connected with the a generic plant; it's better update
        $sample = $this->Phenotype->Sample->save(array(
            'Sample' => array(
                'name' => $line_parts[7],
                'created' => $this->_convert_date($line_parts[9]) . ' ' . $line_parts[10],
                'plant_id' => $plant['Plant']['id'],
            ),
        ));

        if (empty($sample)) {
            return false;
        }

        return true;
    }

    function _split_fastscore($line) {
        return preg_split('/;|\t/', $line);
    }

    /**
        Detects the phenotyping program used.
        Gets the entity and attribute id so we can determine if this is a true phenotyping file or a logistics file
     */
    function _preprocess_line($line, $program_id) {
        # split the line according to the program
        list($version, $object, $program, $entity_id, $attribute_id) = preg_split('/;|\t/', $line);
        if ($program_id == 0) { # how the 'autodetection' works ;)
            if ($program == 'Fast Score') {
                $program_id = 1;
            }
            elseif ($program == 'Phenotyping') {
                $program_id = 2;
            }
            else {
                $program_id = 0;
            }
        }

        return array($program_id, $entity_id, $attribute_id);
    }

    function _save_upload($line, $program_id, $raw_id, $line_nr) {
        #init
        $version = $object = $program = $entity_id = $attribute_id = $attribute_name = $attribute_state = $sample_id = $attribute_value = $date = $time = $bbch_id = $bbch_name = $entity_name = null;

        if ($program_id == 1) { # FastScore
            list($version, $object, $program, $entity_id, $attribute_id, $attribute_name, $attribute_state, $sample_id, $attribute_number, $date, $time) = $this->_split_fastscore($line);
        }
        elseif ($program_id == 2) { # Phenotyping
            list($version, $object, $program, $sample_id, $bbch_id, $bbch_name, $date, $time, $entity_id, $enity_name, $attribute_id, $attribute_state, $attribute_value, $attribute_number) = preg_split('/;|\t/', $line);
        }
        elseif ($program_id == 3) { # BBCH
            list($version, $object, $program, $sample_id, $bbch_id, $bbch_name, $date, $time) = preg_split('/;|\t/', $line);
        }
        $date = $this->_convert_date($date);
        $attribute_number = str_replace(',', '.', $attribute_number); # Germanify the number (this should be done easier somehow)

        # TODO maybe it could be easier to create the correct array to save instead of saving each model individually; Oh man, why again didn't I do this??
        # actually wouldn't work! We need to look up each model id or it will be saved as a new entry

        $sample = $this->_get_sample($sample_id);
        $phenotype = $this->_save_phenotype(am(array('sample_id' => $sample['Sample']['id']), compact('program_id', 'version', 'object', 'date', 'time' )));
        $this->_save_raw($raw_id, $phenotype['Phenotype']['id'], $line_nr);
        $entity = $this->_save_entity($entity_id, $phenotype['Phenotype']['id']);
        $value = $this->_save_value($attribute_id, $attribute_number, $phenotype['Phenotype']['id']);

        if ($program_id != 1) {
            $this->_save_bbch($bbch_id, $phenotype['Phenotype']['id']);
        }

        return $this->Phenotype->getLastInsertID();
    }

    function _save_bbch($bbch_id, $ph_id, $species_id = 1) {
        # look the right code up (as bbch_id != bbch.id)
        $bbch = $this->Phenotype->PhenotypeBbch->Bbch->find('first', array('conditions' => array('bbch' => $bbch_id)));
        if (empty($bbch)) { # oops. Let's create a placeholder instead
            $this->Phenotype->PhenotypeBbch->Bbch->save(array(
                'Bbch' => array(
                    'name' => 'Placeholder',
                    'bbch' => $bbch_id,
                    'species_id' => $species_id,
                ),
            ));
        }
        $this->Phenotype->PhenotypeBbch->create();
        $ph_bbch = $this->Phenotype->PhenotypeBbch->save(array(
            'PhenotypeBbch' => array(
                'phenotype_id' => $ph_id,
                'bbch_id' => $bbch['Bbch']['id'],
            )
        ));
    }

    function _save_value($attribute_id, $attribute_number = null, $ph_id) {
        # first make sure we have a Value to link to
        $this->_spawn_model('Value', $attribute_id, array('attribute' => 'placeholder', 'value' => 'placeholder'));
        # save the attribute info
        $this->Phenotype->PhenotypeValue->create();
        $attribute_number = ! is_null($attribute_number) ? $attribute_number : null;
        if (! ($ph_attribute = $this->Phenotype->PhenotypeValue->save(array(
            'PhenotypeValue' => array(
                'phenotype_id' => $this->Phenotype->getLastInsertID(),
                'value_id' => $attribute_id,
                'number' => $attribute_number,
            )
        )))) {
            $this->Phenotype->rollback();
            $this->error_msg = 'Failed to create PhenotypeValue!';
            return false;
        }
    }

    function _save_entity($entity_id, $ph_id) {
        # save the entity info # TODO check if entity ID exists and matches!
        # well, it errors when it doesn't ;)
        # different tactic: if it doesn't exist: just add the Value as a 'please fill in'
        $this->Phenotype->PhenotypeEntity->create();
        if (! ($ph_entity = $this->Phenotype->PhenotypeEntity->save(array(
            'PhenotypeEntity' => array(
                'phenotype_id' => $ph_id,
                'entity_id' => $entity_id,
            )
        )))) {
            $this->Phenotype->rollback();
            $this->error_msg = 'Failed to create PhenotypeEntity!';
            return false;
        }

    }

    function _save_raw($raw_id, $ph_id, $line_nr) {
        # connect this line with the raw file
        $this->Phenotype->PhenotypeRaw->create();
        if( ! ($ph_raw = $this->Phenotype->PhenotypeRaw->save(array(
            'PhenotypeRaw' => array(
                'raw_id' => $raw_id,
                'phenotype_id' => $ph_id,
                'line_nr' => $line_nr,
            )
        )))) {
            $this->Phenotype->rollback();
            $this->error_msg = 'Failed to create phenotyeRaw!';
            return false;
        }

        return $ph_raw;
    }

    function _save_phenotype($tuples) {
        # save the phenotyping info
        $this->Phenotype->create();
        #$date = implode('-', array_reverse(explode('-', $date)));
        $phenotype = $this->Phenotype->save(array(
            'Phenotype' => $tuples, # version, object, program_id, date, time, sample_id
        ));
        if (empty($phenotype)) {
            $this->Phenotype->rollback();
            $this->error_msg = 'Failed to create Phenotype!';
            return false;
        }
        else {
            $phenotype['Phenotype']['id'] = $this->Phenotype->getLastInsertID();
        }

        return $phenotype;
    }

    function _get_sample($sample_id) {
        # insert the sample info
        $sample = $this->Phenotype->Sample->find('first', array('conditions' => array('Sample.name' => $sample_id)));
        if (empty($sample)) {
            $gen_plant_id = $this->_get_generic_plant();
            $this->Phenotype->Sample->create();
            $sample = $this->Phenotype->Sample->save(array(
                'Sample' => array(
                    'name' => $sample_id,
                    'plant_id' => $gen_plant_id, # will get connected once the propper component_id file is uploaded
                )
            ));
            if (empty($sample)) {
                $this->Phenotype->rollback();
                $this->error_msg = 'No sample found!';
                return false;
            }
            $sample['Sample']['id'] = $this->Phenotype->Sample->getLastInsertID();
        }
        #else {
        #    $this->Phenotype->rollback();
        #    return false;
        #}

        return $sample;
    }

    /**
     * checks if a certain tuple exists, and if not, creates one
     * @param $model string model name
     * @param $id int id of the tuple to look up
     * @param $attributes array when tuple doesn't 
     */
    function _spawn_model($model, $id, $attributes) {
        $tuple = $this->$model->find('first', array('conditions' => array(
            "$model.id" => $id
        )));

        if (empty($tuple)) {
            $this->$model->create();
            $tuple = $this->$model->save(array(
                $model => am(compact('id'), $attributes)
            ));
            $tuple[$model]['id'] = $this->$model->getLastInsertID();
        }

        return $tuple[$model]['id'];
    }

    function _get_generic_plant() {
        $plant_id = 1;
        $plant = $this->Phenotype->Sample->Plant->find('first', array('conditions' => array(
            'Plant.id' => $plant_id
        )));

        if (empty($plant)) {
            $this->Phenotype->Sample->Plant->create();
            $plant = $this->Phenotype->Sample->Plant->save(array(
                'Plant' => array(
                    'id' => $plant_id,
                    'aliquot' => 'placeholder',
                    'culture_id' => 1
                ),
            ));
        }

        return $plant_id;
    }

    /**
     * Tries to detect and convert dates to yyyy-mm-dd format.
     */
    function _convert_date($date) {
        list($year, $month, $day) = preg_split('/[^0-9]/', $date);
        if (strlen($day) == 4) { # switch day and year if they seem to be reversed
            $x = $year;
            $year = $day;
            $day = $x;
        }
        # it seems dates are sometimes given as '06-03-11' which is TOTALLY AMbIGUOUS!
        # anyway, check if all dates are above 2011
        elseif ($year < 2010) {
            $x = $year;
            $year = $day;
            $day = $x;
        }

        # quick hack so that those ungly US noted dates are uploaded
        #$x = $month;
        #$month = $day;
        #$day = $x;

        #if ($day < 10) $day = "0$day";
        #if ($month < 10) $month = "0$month";
        if ($year == 11) $year = 2011;

        return "$year-$month-$day";
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
            $line .= ';'. $this->data['Sample']['name'];
            $line .= ';'. $this->data['PhenotypeValue']['number'];
            $line .= ';'. $this->Phenotype->deconstruct('date', $this->data['Phenotype']['date']);
            $line .= ';'. $this->Phenotype->deconstruct('time', $this->data['Phenotype']['time']);
        }
        if ($program_id == 2) { # phenotyping
            $line .= $this->data['Phenotype']['version'];
            $line .= ';'. $this->data['Phenotype']['object'];
            $line .= ';Phenotyping';
            $line .= ';'. $this->data['Sample']['name'];
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
        # save the RAW
        $raw = null;
        if ($this->data['PhenotypeRaw']['raw_id']) { # ow, we already saved it, so read it and append
            # read it in
            $raw = $this->Phenotype->PhenotypeRaw->Raw->read(null, $this->data['PhenotypeRaw']['raw_id']);
            # append
            $raw['Raw']['data'] .= "\n$line";
        }
        else {
            $raw['Raw']['data'] = $line;
        }
        $line_nr = 1;
        if ($this->Phenotype->PhenotypeRaw->Raw->save($raw)) {
            if (!empty($raw['PhenotypeRaw'])) {
                # first get the last line_nr by reverse sorting them 
                # (there actually is no reason why this shouldn't be
                # just the last record in the PhenotypeRaw model of a certain Raw?)
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

        # save the line
        $phenotype_id = $this->_save_upload($line, $program_id, $raw['Raw']['id'], ++$line_nr);
        if (!$phenotype_id) {
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
                $this->Phenotype->commit();
                #unset($this->data['PhenotypeEntity']['entity_id']);
                #unset($this->data['PhenotypeValue']['value_id']);
                #unset($this->data['Value']['attribute']);
                unset($this->data['PhenotypeValue']['Number']);
                unset($this->data['Phenotype']['time']);
                unset($this->data['Form']['posted']);
                $this->data['PhenotypeRaw']['raw_id'] = $raw_id;
                if ($this->data['Form']['lastone'] == 1) {
                    $this->redirect(array('controller' => 'raws', 'action'=>'view', $raw_id));
                }
                $this->set('phenotypes', $this->Phenotype->PhenotypeRaw->Raw->find('first', array('conditions' => array('Raw.id' => $raw_id), 'contain' => array('Phenotype.Sample', 'Phenotype.Entity', 'Phenotype.Value', 'Phenotype.Bbch'))));
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
		$samples = $this->Phenotype->Sample->find('list');
		$this->set(compact('programs', 'samples'));
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
