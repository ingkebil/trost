<div class="samplePlants form">
<?php echo $this->Form->create('SamplePlant');?>
	<fieldset>
 		<legend><?php __('Edit Sample Plant'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sample_id');
		echo $this->Form->input('plant_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('SamplePlant.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('SamplePlant.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sample Plants', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>