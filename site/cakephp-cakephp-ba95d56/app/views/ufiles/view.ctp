<div class="ufiles view">
<h2><?php  __('Ufile');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufile['Ufile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Submitter'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufile['Ufile']['submitter']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufile['Ufile']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufile['Ufile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ufile['Ufile']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ufile', true), array('action' => 'edit', $ufile['Ufile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ufile', true), array('action' => 'delete', $ufile['Ufile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufile['Ufile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ufiles', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufile', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ufilekeywords', true), array('controller' => 'ufilekeywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('controller' => 'ufilekeywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Ufilekeywords');?></h3>
	<?php if (!empty($ufile['Ufilekeyword'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Ufile Id'); ?></th>
		<th><?php __('Keyword Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ufile['Ufilekeyword'] as $ufilekeyword):
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
<div class="related">
	<h3><?php __('Related Keywords');?></h3>
	<?php if (!empty($ufile['Keyword'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ufile['Keyword'] as $keyword):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $keyword['id'];?></td>
			<td><?php echo $keyword['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'keywords', 'action' => 'view', $keyword['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'keywords', 'action' => 'edit', $keyword['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'keywords', 'action' => 'delete', $keyword['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $keyword['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
