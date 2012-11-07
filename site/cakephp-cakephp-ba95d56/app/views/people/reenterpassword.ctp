<div class="people form">
<?php echo $this->Form->create('Person', array('url' => array($token)));?>
	<fieldset>
 		<legend><?php __('Reset Password'); ?></legend>
	<?php
		echo $this->Form->input('password', array('value' => ''));
		echo $this->Form->input('password_confirm', array('type' => 'password', 'value' => ''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
