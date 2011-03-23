<div class="phenotypeValues form">
<?php echo $this->Form->create('PhenotypeValue');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype Value'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('value_id');
		echo $this->Form->input('phenotype_id');
		echo $this->Form->input('number');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('PhenotypeValue.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('PhenotypeValue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Phenotype Values', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Values', true), array('controller' => 'values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Value', true), array('controller' => 'values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>