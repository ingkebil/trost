<div class="ufiles form">
<?php echo $this->Form->create('Ufile');?>
	<fieldset>
 		<legend><?php __('Edit Ufile'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('submitter');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('Keyword');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
