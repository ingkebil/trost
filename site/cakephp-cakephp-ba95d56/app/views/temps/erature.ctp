<div class="temps form">
<?php echo $this->Form->create('Temp');?>
	<fieldset>
 		<legend><?php __('Add Temp'); ?></legend>
	<?php
		echo $this->Form->input('datum', array('dateFormat' => 'DMY'));
		echo $this->Form->input('rainfall');
		echo $this->Form->input('tmin');
		echo $this->Form->input('tmax');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
