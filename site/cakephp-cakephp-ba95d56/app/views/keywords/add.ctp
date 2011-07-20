<div class="keywords form">
<?php echo $this->Form->create('Keyword');?>
	<fieldset>
 		<legend><?php __('Add Keyword'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
