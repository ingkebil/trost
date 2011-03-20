<?php echo $javascript->link('prototype', false); ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Phenotype'); ?></legend>
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

		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Programs', true), array('controller' => 'programs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program', true), array('controller' => 'programs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Attributes', true), array('controller' => 'phenotype_attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Attribute', true), array('controller' => 'phenotype_attributes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('controller' => 'phenotype_bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('controller' => 'phenotype_bbches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Entities', true), array('controller' => 'phenotype_entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('controller' => 'phenotype_entities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('controller' => 'phenotype_raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('controller' => 'phenotype_raws', 'action' => 'add')); ?> </li>
	</ul>
</div>
