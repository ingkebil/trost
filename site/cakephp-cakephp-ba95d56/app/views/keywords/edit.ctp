<div class="keywords form">
<?php echo $this->Form->create('Keyword');?>
	<fieldset>
 		<legend><?php __('Edit Keyword'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Keyword.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Keyword.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('controller' => 'ufilekeywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add')); ?> </li>
	</ul>
</div>