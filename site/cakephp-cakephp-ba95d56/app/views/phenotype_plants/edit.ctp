<div class="phenotypePlants form">
<?php echo $this->Form->create('PhenotypePlant');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype Plant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('plant_id');
		echo $this->Form->input('phenotype_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('PhenotypePlant.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('PhenotypePlant.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Phenotype Plants', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>