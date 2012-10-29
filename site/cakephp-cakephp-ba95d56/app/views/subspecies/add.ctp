<div class="subspecies form">
<?php echo $this->Form->create('Subspecy');?>
	<fieldset>
 		<legend><?php __('Add Subspecy'); ?></legend>
	<?php
		echo $this->Form->input('species_id');
		echo $this->Form->input('cultivar');
		echo $this->Form->input('breeder');
		echo $this->Form->input('reifegruppe');
		echo $this->Form->input('reifegrclass');
		echo $this->Form->input('krautfl');
		echo $this->Form->input('verwendung');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Subspecies', true), array('action' => 'index'));?></li>
	</ul>
</div>