<?php
    # create some easy to look up arrays
    $entities_str = array();
    foreach ($entities_ as $id => $entity) { 
        $entities_str[] = "$id:'$entity'";
    }
    $entities_str = '{'.implode(',', $entities_str).'}';

    $attributes_str = array();
    foreach ($attributes_ as $id => $attribute) { 
        $attributes_str[] = "$id:'$attribute'";
    }
    $attributes_str= '{'.implode(',', $attributes_str).'}';

    $values = array();
    foreach ($values_ as $id => $value) { 
        $values_str[] = "$id:'$value'";
    }
    $values_str = '{'.implode(',', $values_str).'}';
?>
<?php
    echo $javascript->link('jquery-1.5.1.min', false);
    echo $javascript->codeBlock("
        var entities = $entities_str;
        var attributes = $attributes_str;
        var values = $values_str;

        function change_phenotypevalueid(el) {
            $('#ValueAttribute').val(attributes[$(el).val()]);
            $('#_ValueAttribute').val(attributes[$(el).val()]);
            $('#ValueValue').val(values[$(el).val()]);
            $('#_ValueValue').val(values[$(el).val()]);
        }

        function change_entityname(el) {
            if ($(el).val() in entities) {
                $('#EntityName').val(entities[$(el).val()]);
                $('#_EntityName').val(entities[$(el).val()]);
            }
            else {
                $('#EntityName').val('".__('undefined', true)."');
                $('#_EntityName').val('".__('undefined', true)."');
            }
        }

        $(document).ready(function() {
            if ($('#PhenotypeEntityEntityId').val()) {
                change_entityname('#PhenotypeEntityEntityId');
            }
            if ($('#PhenotypeValueValueId').val()) {
                change_phenotypevalueid('#PhenotypeValueValueId');
            }
            $('#PhenotypeEntityEntityId').change(function(event) {
                change_entityname('#PhenotypeEntityEntityId');
            });

            $('#PhenotypeValueValueId').change(function(event) {
                change_phenotypevalueid('#PhenotypeValueValueId');
            });
        });
    ");
?>
<?php

    echo $this->Form->input('Phenotype.version');
    echo $this->Form->input('Phenotype.object');
    echo $this->Form->label(__('entity id', true));
    echo $this->Form->text('PhenotypeEntity.entity_id');
    echo $this->Form->input('_Entity.name', array('disabled' => 'disabled'));
    echo $this->Form->hidden('Entity.name');
    echo $this->Form->label(__('value id', true));
    echo $this->Form->text('PhenotypeValue.value_id');
    echo $this->Form->input('_Value.attribute', array('disabled' => 'disabled'));
    echo $this->Form->hidden('Value.attribute');
    echo $this->Form->input('_Value.value', array('disabled' => 'disabled'));
    echo $this->Form->hidden('Value.value');
    echo $this->Form->input('Plant.aliquot');
    echo $this->Form->input('PhenotypeValue.number');
    echo $this->Form->input('Phenotype.date');
    echo $this->Form->input('Phenotype.time');

?>
