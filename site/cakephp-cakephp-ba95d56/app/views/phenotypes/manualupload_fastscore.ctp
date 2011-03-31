<?php echo $javascript->link('prototype', false); ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Upload scanner file'); ?></legend>
	<?php

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('Manual Input', true), array('action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index'));?></li>
	</ul>
</div>
