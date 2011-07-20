<div class="ufiles form">
<?php echo $this->Form->create('Ufile');?>
	<fieldset>
 		<legend><?php __('Add Ufile'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Ufiles', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('controller' => 'ufilekeywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>