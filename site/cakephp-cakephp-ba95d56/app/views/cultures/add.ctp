<div class="cultures form">
<?php echo $this->Form->create('Culture');?>
	<fieldset>
 		<legend><?php __('Add Culture'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('limsstudyid');
		echo $this->Form->input('condition');
		echo $this->Form->input('description');
		echo $this->Form->input('experiment_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cultures', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Experiments', true), array('controller' => 'experiments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Experiment', true), array('controller' => 'experiments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>