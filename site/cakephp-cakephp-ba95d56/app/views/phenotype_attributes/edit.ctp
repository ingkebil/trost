<div class="phenotypeAttributes form">
<?php echo $this->Form->create('PhenotypeAttribute');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype Attribute'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('attribute_id');
		echo $this->Form->input('phenotype_id');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('PhenotypeAttribute.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('PhenotypeAttribute.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Phenotype Attributes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Attributes', true), array('controller' => 'attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attribute', true), array('controller' => 'attributes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>