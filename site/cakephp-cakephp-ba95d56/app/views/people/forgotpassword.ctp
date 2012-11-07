<div class="people form">
<?php echo $this->Form->create('Person', array('action' => 'forgotpassword'));?>
	<fieldset>
 		<legend><?php __('Forget password'); ?></legend>
	<?php echo $this->Form->input('username'); ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
