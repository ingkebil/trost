<div class="entities form">
<?php echo $this->Form->create('Entity');?>
	<fieldset>
 		<legend><?php __('Edit Entity'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('PO');
		echo $this->Form->input('definition');
		echo $this->Form->input('Phenotype');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Entity.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Entity.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Entities', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>