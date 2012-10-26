<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Add Phenotype'); ?></legend>
	<?php
		echo $this->Form->input('version');
		echo $this->Form->input('object');
		echo $this->Form->input('program_id');
		echo $this->Form->input('date');
		echo $this->Form->input('time');
        echo $this->Form->input('entity_id');
        echo $this->Form->input('value_id');
        echo $this->Form->input('number');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
