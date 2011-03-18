<div class="phenotypeBbches form">
<?php echo $this->Form->create('PhenotypeBbch');?>
	<fieldset>
 		<legend><?php __('Add Phenotype Bbch'); ?></legend>
	<?php
		echo $this->Form->input('phenotype_id');
		echo $this->Form->input('bbch_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('controller' => 'bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bbch', true), array('controller' => 'bbches', 'action' => 'add')); ?> </li>
	</ul>
</div>