<div class="plants form">
<?php echo $this->Form->create('Plant');?>
	<fieldset>
 		<legend><?php __('Edit Plant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('aliquot');
		echo $this->Form->input('culture_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Plant.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Plant.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
	</ul>
</div>