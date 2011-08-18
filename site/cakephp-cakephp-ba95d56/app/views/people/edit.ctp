<div class="people form">
<?php echo $this->Form->create('Person');?>
	<fieldset>
 		<legend><?php __('Edit Person'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username');
		echo $this->Form->input('name');
		echo $this->Form->input('location_id');
		echo $this->Form->input('password', array('value' => ''));
		echo $this->Form->input('password_confirm', array('type' => 'password'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
