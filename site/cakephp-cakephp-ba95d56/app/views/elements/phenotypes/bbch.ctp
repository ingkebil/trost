<?php
    echo $javascript->link('jquery-1.5.1.min', false);
    if (!$drop) {
        # create some easy to look up arrays
        $bbchs = array();
        foreach ($bbchs_ as $id => $bbch) { 
            $bbchs_str[] = "$id:'$bbch'";
        }
        $bbchs_str = '{'.implode(',', $bbchs_str).'}';

        echo $javascript->codeBlock("
            var bbchs = $bbchs_str;

            function change_phenotypebbch(el) {
                $('#BbchName').val(bbchs[$(el).val()]);
                $('#_BbchName').val(bbchs[$(el).val()]);
            }

            $(document).ready(function() {
                if ($('#PhenotypeBbchBbch').val()) {
                    change_phenotypebbch('#PhenotypeBbchBbch');
                }

                $('#PhenotypeBbchBbch').change(function(event) {
                    change_phenotypebbch('#PhenotypeBbchBbch');
                });
            });
        ");
    }
?>
<?php

    if (!$drop) {
        echo $this->Form->hidden('Phenotype.version', array('value' => 'manuel'));
        echo $this->Form->hidden('Phenotype.object', array('value' => 'LIMS aliquot')); # TODO remove this hardcoded object
        echo $this->Form->input('Sample.name');
        echo $this->Form->input('PhenotypeBbch.bbch');
        echo $this->Form->input('_Bbch.name', array('disabled' => 'disabled'));
        echo $this->Form->hidden('Bbch.name');
        echo $this->Form->input('Phenotype.date');
        echo $this->Form->input('Phenotype.time');
    }
    else {
        echo $this->Form->hidden('Phenotype.version', array('value' => 'manuel'));
        echo $this->Form->hidden('Phenotype.object', array('value' => 'LIMS aliquot')); # TODO remove this hardcoded object
        echo $this->Form->input('Sample.name');
        echo $this->Form->label(__('Bbch Code', true));
        echo $this->Form->select('PhenotypeBbch.bbch', $bbchs);
        echo $this->Form->input('Phenotype.date');
        echo $this->Form->input('Phenotype.time');
    }

?>
