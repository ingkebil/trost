<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    $(document).ready(function() {
        $("#FileRaw").change(function() {
            if ($(this).val()) {
                $("#FileManual").attr("disabled", "disabled");
            }
            else {
                $("#FileManual").attr("disabled", "");
            }
        });
        
        $("#FileManual").change(function() {
            if ($(this).is(":checked")) {
                $("#FileRaw").attr("disabled", "disabled");
                if ($("#PhenotypeProgramId").val()==0) {
                    $("#PhenotypeProgramId").val(1);
                }
            }
            else {
                $("#FileRaw").attr("disabled", "");
            }
        });

        //if ($("#CultureExperimentId").val()) {
        //    '.$this->Ajax->remoteFunction(array('url' => 'get_cultures', 'update' => 'PlantCultureId', 'data' => '$("#CultureExperimentId").serialize()')).'
        //}
    });
'); ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Upload scanner file'); ?></legend>
	<?php

		echo $this->Form->input('Culture.experiment_id');
		echo $this->Form->input('Plant.culture_id');
		echo $this->Form->input('program_id');

        #echo $ajax->observeField('CultureExperimentId', array(
        #    'url' => 'get_cultures',
        #    'update' => 'PlantCultureId'
        #));

        echo $this->Form->file('File.raw', array('label' => 'File upload'));
    ?>
    <br />
    <br />
    <hr />
    <br />
    <?php
        echo $this->Form->checkbox('File.manual');
        echo $this->Form->label('File.manual',  __('Input manually', true));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index'));?></li>
	</ul>
</div>
