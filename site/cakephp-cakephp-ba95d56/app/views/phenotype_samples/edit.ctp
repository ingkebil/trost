<div class="phenotypeSamples form">
<?php echo $this->Form->create('PhenotypeSample');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype Sample'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sample_id');
		echo $this->Form->input('phenotype_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('PhenotypeSample.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('PhenotypeSample.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Phenotype Samples', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>