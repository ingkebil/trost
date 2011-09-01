<div class="ufiles form">
<?php echo $this->Form->create('Ufile');?>
	<fieldset>
 		<legend><?php __('Search file'); ?></legend>
	<?php
		echo $this->Form->input('person_id', array('empty' => true));
		echo $this->Form->input('location_id', array('empty' => true));
		echo $this->Form->input('name', array('label' => 'filename'));
		echo $this->Form->input('description');
		echo $this->Form->input('Keyword');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
