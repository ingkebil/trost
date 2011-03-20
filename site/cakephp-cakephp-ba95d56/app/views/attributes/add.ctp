<div class="attributes form">
<?php echo $this->Form->create('Attribute');?>
	<fieldset>
 		<legend><?php __('Add Attribute'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('state');
		echo $this->Form->input('Phenotype');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Attributes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>