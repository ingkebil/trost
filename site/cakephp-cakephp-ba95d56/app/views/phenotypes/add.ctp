<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Add Phenotype'); ?></legend>
	<?php
		echo $this->Form->input('version');
		echo $this->Form->input('object');
		echo $this->Form->input('program_id');
		echo $this->Form->input('date');
		echo $this->Form->input('time');
		echo $this->Form->input('plant_id');
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
		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('controller' => 'phenotype_bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('controller' => 'phenotype_bbches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Entities', true), array('controller' => 'phenotype_entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('controller' => 'phenotype_entities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('controller' => 'phenotype_raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('controller' => 'phenotype_raws', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Values', true), array('controller' => 'phenotype_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Value', true), array('controller' => 'phenotype_values', 'action' => 'add')); ?> </li>
	</ul>
</div>