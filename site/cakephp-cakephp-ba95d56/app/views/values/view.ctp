<div class="values view">
<h2><?php  __('Value');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $value['Value']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attribute'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $value['Value']['attribute']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $value['Value']['value']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Value', true), array('action' => 'edit', $value['Value']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Value', true), array('action' => 'delete', $value['Value']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $value['Value']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Values', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Value', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Phenotypes');?></h3>
	<?php if (!empty($value['Phenotype'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Version'); ?></th>
		<th><?php __('Object'); ?></th>
		<th><?php __('Program Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Time'); ?></th>
		<th><?php __('Plant Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($value['Phenotype'] as $phenotype):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotype['id'];?></td>
			<td><?php echo $phenotype['version'];?></td>
			<td><?php echo $phenotype['object'];?></td>
			<td><?php echo $phenotype['program_id'];?></td>
			<td><?php echo $phenotype['date'];?></td>
			<td><?php echo $phenotype['time'];?></td>
			<td><?php echo $phenotype['plant_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotypes', 'action' => 'view', $phenotype['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotypes', 'action' => 'edit', $phenotype['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotypes', 'action' => 'delete', $phenotype['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotype['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
