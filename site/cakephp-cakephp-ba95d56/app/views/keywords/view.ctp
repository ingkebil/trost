<div class="keywords view">
<h2><?php  __('Keyword');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $keyword['Keyword']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $keyword['Keyword']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Keyword', true), array('action' => 'edit', $keyword['Keyword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Keyword', true), array('action' => 'delete', $keyword['Keyword']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $keyword['Keyword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('controller' => 'ufilekeywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Ufilekeywords');?></h3>
	<?php if (!empty($keyword['Ufilekeyword'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Ufile Id'); ?></th>
		<th><?php __('Keyword Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($keyword['Ufilekeyword'] as $ufilekeyword):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $ufilekeyword['id'];?></td>
			<td><?php echo $ufilekeyword['ufile_id'];?></td>
			<td><?php echo $ufilekeyword['keyword_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'ufilekeywords', 'action' => 'view', $ufilekeyword['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'ufilekeywords', 'action' => 'edit', $ufilekeyword['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'ufilekeywords', 'action' => 'delete', $ufilekeyword['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufilekeyword['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
