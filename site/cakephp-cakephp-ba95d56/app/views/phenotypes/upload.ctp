<?php echo $javascript->link('prototype', false); ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Upload scanner file'); ?></legend>
	<?php

		echo $this->Form->input('Culture.experiment_id', array('empty' => true));
		echo $this->Form->input('Plant.culture_id');
		echo $this->Form->input('program_id');

        echo $ajax->observeField('CultureExperimentId', array(
            'url' => 'get_cultures',
            'update' => 'PlantCultureId'
        ));

        echo $this->Form->file('File.raw', array('label' => 'File upload'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index'));?></li>
	</ul>
</div>
