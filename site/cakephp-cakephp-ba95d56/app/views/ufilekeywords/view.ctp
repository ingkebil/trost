<div class="ufilekeywords view">
<h2><?php  __('Ufilekeyword');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufilekeyword['Ufilekeyword']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ufile'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($ufilekeyword['Ufile']['id'], array('controller' => 'ufiles', 'action' => 'view', $ufilekeyword['Ufile']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Keyword'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($ufilekeyword['Keyword']['id'], array('controller' => 'keywords', 'action' => 'view', $ufilekeyword['Keyword']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ufilekeyword', true), array('action' => 'edit', $ufilekeyword['Ufilekeyword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ufilekeyword', true), array('action' => 'delete', $ufilekeyword['Ufilekeyword']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufilekeyword['Ufilekeyword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ufiles', true), array('controller' => 'ufiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufile', true), array('controller' => 'ufiles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
