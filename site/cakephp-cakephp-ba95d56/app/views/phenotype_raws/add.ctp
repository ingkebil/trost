<div class="phenotypeRaws form">
<?php echo $this->Form->create('PhenotypeRaw');?>
	<fieldset>
 		<legend><?php __('Add Phenotype Raw'); ?></legend>
	<?php
		echo $this->Form->input('phenotype_id');
		echo $this->Form->input('raw_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Raws', true), array('controller' => 'raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Raw', true), array('controller' => 'raws', 'action' => 'add')); ?> </li>
	</ul>
</div>