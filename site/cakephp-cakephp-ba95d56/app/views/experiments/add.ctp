<div class="experiments form">
<?php echo $this->Form->create('Experiment');?>
	<fieldset>
 		<legend><?php __('Add Experiment'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('startdate');
		echo $this->Form->input('project');
		echo $this->Form->input('study');
		echo $this->Form->input('protocol');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Experiments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('controller' => 'cultures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add')); ?> </li>
	</ul>
</div>