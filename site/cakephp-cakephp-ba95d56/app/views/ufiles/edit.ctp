<div class="ufiles form">
<?php echo $this->Form->create('Ufile');?>
	<fieldset>
 		<legend><?php __('Edit Ufile'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('submitter');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('Keyword');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Ufile.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Ufile.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Ufiles', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('controller' => 'ufilekeywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>