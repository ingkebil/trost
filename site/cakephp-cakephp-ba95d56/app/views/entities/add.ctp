<div class="entities form">
<?php echo $this->Form->create('Entity');?>
	<fieldset>
 		<legend><?php __('Add Entity'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('PO');
		echo $this->Form->input('definition');
		echo $this->Form->input('Phenotype');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Entities', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>