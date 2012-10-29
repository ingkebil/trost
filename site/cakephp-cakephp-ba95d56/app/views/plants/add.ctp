<div class="plants form">
<?php echo $this->Form->create('Plant');?>
	<fieldset>
 		<legend><?php __('Add Plant'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('culture_id');
		echo $this->Form->input('subspecies_id');
		echo $this->Form->input('lineid');
		echo $this->Form->input('description');
		echo $this->Form->input('Phenotype');
		echo $this->Form->input('Sample');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Plants', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('controller' => 'cultures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subspecies', true), array('controller' => 'subspecies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subspecies', true), array('controller' => 'subspecies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
	</ul>
</div>