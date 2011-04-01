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

        $(document).ready(function() {
            $('#PhenotypeEntityEntityId').change(function(event) {
                if ($(this).val() in entities) {
                    $('#PhenotypeEntityEntityIdExpl').html(entities[$(this).val()]);
                }
                else {
                    $('#PhenotypeEntityEntityIdExpl').html('".__('undefined', true)."');
                }
            });

            $('#PhenotypeValueValueId').change(function(event) {
                $('#ValueAttribute').val(attributes[$(this).val()]);
                $('#ValueValue').val(values[$(this).val()]);
            });
        });
    ");
?>
<?php

    echo $this->Form->input('Phenotype.version');
    echo $this->Form->input('Phenotype.object');
    echo $this->Form->label(__('entity id', true));
    echo $this->Form->text('PhenotypeEntity.entity_id');
?>
<div id="PhenotypeEntityEntityIdExpl"></div>
<?php
    echo $this->Form->label(__('value id', true));
    echo $this->Form->text('PhenotypeValue.value_id');
    echo $this->Form->input('Value.attribute');
    echo $this->Form->input('Value.value');
    echo $this->Form->input('Plant.aliquot');
    echo $this->Form->input('PhenotypeValue.number');
    echo $this->Form->input('Phenotype.date');
    echo $this->Form->input('Phenotype.time');

?>
