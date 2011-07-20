<div class="ufilekeywords form">
<?php echo $this->Form->create('Ufilekeyword');?>
	<fieldset>
 		<legend><?php __('Add Ufilekeyword'); ?></legend>
	<?php
		echo $this->Form->input('ufile_id');
		echo $this->Form->input('keyword_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Ufiles', true), array('controller' => 'ufiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufile', true), array('controller' => 'ufiles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>