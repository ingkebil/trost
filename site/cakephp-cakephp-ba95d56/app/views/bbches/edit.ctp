<div class="bbches form">
<?php echo $this->Form->create('Bbch');?>
	<fieldset>
 		<legend><?php __('Edit Bbch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('bbch');
		echo $this->Form->input('name');
		echo $this->Form->input('species_id');
		echo $this->Form->input('Phenotype');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Bbch.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Bbch.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Species', true), array('controller' => 'species', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Species', true), array('controller' => 'species', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>