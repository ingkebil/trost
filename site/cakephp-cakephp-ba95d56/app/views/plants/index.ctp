<div class="plants index">
	<h2><?php __('Plants');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('culture_id');?></th>
			<th><?php echo $this->Paginator->sort('subspecies_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('lineid');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($plants as $plant):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $plant['Plant']['id']; ?>&nbsp;</td>
		<td><?php echo $plant['Plant']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($plant['Culture']['name'], array('controller' => 'cultures', 'action' => 'view', $plant['Culture']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($plant['Subspecies']['id'], array('controller' => 'subspecies', 'action' => 'view', $plant['Subspecies']['id'])); ?>
		</td>
		<td><?php echo $plant['Plant']['created']; ?>&nbsp;</td>
		<td><?php echo $plant['Plant']['lineid']; ?>&nbsp;</td>
		<td><?php echo $plant['Plant']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $plant['Plant']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $plant['Plant']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $plant['Plant']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $plant['Plant']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Plant', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cultures', true), array('controller' => 'cultures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Culture', true), array('controller' => 'cultures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Subspecies', true), array('controller' => 'subspecies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subspecies', true), array('controller' => 'subspecies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
	</ul>
</div>