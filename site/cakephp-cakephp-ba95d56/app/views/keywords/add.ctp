<div class="keywords form">
<?php echo $this->Form->create('Keyword');?>
	<fieldset>
 		<legend><?php __('Add Keyword'); ?></legend>
	<?php
		echo $this->Form->input('Keyword.name', array('label' => __('Name in English', true)));
		echo $this->Form->input('Keyword.name_de', array('label' => __('Name in German', true)));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
