<div class="temps form">
<?php echo $this->Form->create('Temp');?>
	<fieldset>
 		<legend><?php __('Add Temp'); ?></legend>
	<?php
		echo $this->Form->input('datum');
		echo $this->Form->input('precipitation');
		echo $this->Form->input('tmin');
		echo $this->Form->input('tmax');
		echo $this->Form->input('location_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Temps', true), array('action' => 'index'));?></li>
	</ul>
</div>
