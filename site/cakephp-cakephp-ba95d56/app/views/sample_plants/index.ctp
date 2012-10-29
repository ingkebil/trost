<div class="samplePlants index">
	<h2><?php __('Sample Plants');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('sample_id');?></th>
			<th><?php echo $this->Paginator->sort('plant_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($samplePlants as $samplePlant):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $samplePlant['SamplePlant']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($samplePlant['Sample']['id'], array('controller' => 'samples', 'action' => 'view', $samplePlant['Sample']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($samplePlant['Plant']['name'], array('controller' => 'plants', 'action' => 'view', $samplePlant['Plant']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $samplePlant['SamplePlant']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $samplePlant['SamplePlant']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $samplePlant['SamplePlant']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $samplePlant['SamplePlant']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Sample Plant', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>