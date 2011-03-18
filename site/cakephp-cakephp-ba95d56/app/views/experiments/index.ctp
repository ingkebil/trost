<div class="experiments index">
	<h2><?php __('Experiments');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('startdate');?></th>
			<th><?php echo $this->Paginator->sort('project');?></th>
			<th><?php echo $this->Paginator->sort('study');?></th>
			<th><?php echo $this->Paginator->sort('protocol');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($experiments as $experiment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $experiment['Experiment']['id']; ?>&nbsp;</td>
		<td><?php echo $experiment['Experiment']['name']; ?>&nbsp;</td>
		<td><?php echo $experiment['Experiment']['startdate']; ?>&nbsp;</td>
		<td><?php echo $experiment['Experiment']['project']; ?>&nbsp;</td>
		<td><?php echo $experiment['Experiment']['study']; ?>&nbsp;</td>
		<td><?php echo $experiment['Experiment']['protocol']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $experiment['Experiment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $experiment['Experiment']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $experiment['Experiment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $experiment['Experiment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Experiment', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('controller' => 'cultures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add')); ?> </li>
	</ul>
</div>