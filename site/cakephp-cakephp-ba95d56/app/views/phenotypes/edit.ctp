<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Edit Phenotype'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('version');
		echo $this->Form->input('object');
		echo $this->Form->input('program_id');
		echo $this->Form->input('date');
		echo $this->Form->input('time');
		echo $this->Form->input('sample_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
