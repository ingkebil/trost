<?php
class Raw extends AppModel {
    var $name = 'Raw';
    var $actsAs = array('Containable');
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    var $hasAndBelongsToMany = array(
        'Phenotype' => array(
            'className' => 'Phenotype',
            'joinTable' => 'phenotype_raws',
            'foreignKey' => 'raw_id',
            'associationForeignKey' => 'phenotype_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    function contains_sampleplant($raw_id) {
        $raws = $this->PhenotypeRaw->find('count', array(
            'joins' => array(
                array(
                    'table' => 'phenotypes',
                    'alias' => 'Phenotype',
                    'type' => 'left',
                    'conditions' => array('PhenotypeRaw.phenotype_id = Phenotype.id'),
                ),
                array(
                    'table' => "phenotype_entities",
                    'alias' => "PhenotypeEntity",
                    'type' => 'LEFT',
                    'conditions' => array("PhenotypeEntity.phenotype_id = Phenotype.id"),
                ),
                array(
                    'table' => "phenotype_values",
                    'alias' => "PhenotypeValue",
                    'type' => 'LEFT',
                    'conditions' => array("PhenotypeValue.phenotype_id = Phenotype.id"),
                ),
            ),
            'conditions' => array(
                'PhenotypeEntity.entity_id' => 808,
                'PhenotypeValue.value_id' => 178,
                'PhenotypeRaw.raw_id' => $raw_id
            ),
            'contain' => false
        ));

        return $raws;
    }

    function find_phenotype_daterange($raw_id) {
        $daterange = $this->PhenotypeRaw->find('first', array(
            'conditions' => array(
                'PhenotypeRaw.raw_id' => $raw_id,
            ),
            'fields' => array('Phenotype.id', 'min(Phenotype.date) AS mindate', 'max(Phenotype.date) AS maxdate'),
            'contain' => array('Phenotype'),
        ));

        if (array_key_exists(0, $daterange)) {
            $daterange = am($daterange['Phenotype'], $daterange[0]);
            unset($daterange[0]);
        }

        return $daterange;
    }

    function _count_table($alias, $raw_id) {
        $table = Inflector::tableize($alias);
        return $this->PhenotypeRaw->find('count', array(
            'joins' => array(
                array(
                    'table' => 'phenotypes',
                    'alias' => 'Phenotype',
                    'type' => 'inner',
                    'conditions' => array('PhenotypeRaw.phenotype_id = Phenotype.id'),
                ),
                array(
                    'table' => "phenotype_$table",
                    'alias' => "Phenotype$alias",
                    'type' => 'inner',
                    'conditions' => array("Phenotype$alias.phenotype_id = Phenotype.id"),
                ),
            ),
            'conditions' => array('PhenotypeRaw.raw_id' => $raw_id),
            'contain' => false
        ));
    }

    function count_bbch($raw_id) {
        return $this->_count_table('Bbch', $raw_id);
    }

    function count_entity($raw_id) {
        return $this->_count_table('Entity', $raw_id);
    }

    function count_value($raw_id) {
        return $this->_count_table('Value', $raw_id);
    }

    function count_sample($raw_id) {
        return $this->PhenotypeRaw->find('count', array(
            'joins' => array(
                array(
                    'table' => 'phenotypes',
                    'alias' => 'Phenotype',
                    'type' => 'inner',
                    'conditions' => array('PhenotypeRaw.phenotype_id = Phenotype.id'),
                ),
                array(
                    'table' => "samples",
                    'alias' => "Sample",
                    'type' => 'left',
                    'conditions' => array("Sample.id = Phenotype.sample_id"),
                ),
            ),
            'conditions' => array('PhenotypeRaw.raw_id' => $raw_id),
            'contain' => false
        ));
    }

}
?>
