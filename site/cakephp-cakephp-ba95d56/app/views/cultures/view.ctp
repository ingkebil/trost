<div class="cultures view">
<h2><?php  __('Culture');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Limsstudyid'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['limsstudyid']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Condition'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['condition']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $culture['Culture']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Experiment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($culture['Experiment']['name'], array('controller' => 'experiments', 'action' => 'view', $culture['Experiment']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Culture', true), array('action' => 'edit', $culture['Culture']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Culture', true), array('action' => 'delete', $culture['Culture']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $culture['Culture']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Experiments', true), array('controller' => 'experiments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Experiment', true), array('controller' => 'experiments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Plants');?></h3>
	<?php if (!empty($culture['Plant'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Aliquot'); ?></th>
		<th><?php __('Culture Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Sample Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($culture['Plant'] as $plant):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $plant['id'];?></td>
			<td><?php echo $plant['name'];?></td>
			<td><?php echo $plant['aliquot'];?></td>
			<td><?php echo $plant['culture_id'];?></td>
			<td><?php echo $plant['created'];?></td>
			<td><?php echo $plant['sample_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'plants', 'action' => 'view', $plant['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'plants', 'action' => 'edit', $plant['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'plants', 'action' => 'delete', $plant['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $plant['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
