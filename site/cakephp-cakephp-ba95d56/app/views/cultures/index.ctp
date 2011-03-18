<div class="cultures index">
	<h2><?php __('Cultures');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('condition');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('experiment_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($cultures as $culture):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $culture['Culture']['id']; ?>&nbsp;</td>
		<td><?php echo $culture['Culture']['name']; ?>&nbsp;</td>
		<td><?php echo $culture['Culture']['condition']; ?>&nbsp;</td>
		<td><?php echo $culture['Culture']['created']; ?>&nbsp;</td>
		<td><?php echo $culture['Culture']['description']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($culture['Experiment']['name'], array('controller' => 'experiments', 'action' => 'view', $culture['Experiment']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $culture['Culture']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $culture['Culture']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $culture['Culture']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $culture['Culture']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Culture', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Experiments', true), array('controller' => 'experiments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Experiment', true), array('controller' => 'experiments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>