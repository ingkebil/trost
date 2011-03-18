<div class="samples form">
<?php echo $this->Form->create('Sample');?>
	<fieldset>
 		<legend><?php __('Edit Sample'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('supplier');
		echo $this->Form->input('created_by');
		echo $this->Form->input('mag');
		echo $this->Form->input('alias');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Sample.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Sample.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>