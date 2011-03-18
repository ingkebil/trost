<div class="species form">
<?php echo $this->Form->create('Species');?>
	<fieldset>
 		<legend><?php __('Edit Species'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Species.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Species.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Species', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('controller' => 'bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bbch', true), array('controller' => 'bbches', 'action' => 'add')); ?> </li>
	</ul>
</div>