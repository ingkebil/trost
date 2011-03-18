<div class="experiments view">
<h2><?php  __('Experiment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Startdate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['startdate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Project'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['project']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Study'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['study']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Protocol'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $experiment['Experiment']['protocol']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Experiment', true), array('action' => 'edit', $experiment['Experiment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Experiment', true), array('action' => 'delete', $experiment['Experiment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $experiment['Experiment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Experiments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Experiment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('controller' => 'cultures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Cultures');?></h3>
	<?php if (!empty($experiment['Culture'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Condition'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Experiment Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($experiment['Culture'] as $culture):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $culture['id'];?></td>
			<td><?php echo $culture['name'];?></td>
			<td><?php echo $culture['condition'];?></td>
			<td><?php echo $culture['created'];?></td>
			<td><?php echo $culture['description'];?></td>
			<td><?php echo $culture['experiment_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'cultures', 'action' => 'view', $culture['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'cultures', 'action' => 'edit', $culture['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'cultures', 'action' => 'delete', $culture['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $culture['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
