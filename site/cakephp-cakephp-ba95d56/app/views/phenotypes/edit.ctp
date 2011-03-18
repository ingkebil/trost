<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Phenotype.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Phenotype.id'))); ?></li>
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