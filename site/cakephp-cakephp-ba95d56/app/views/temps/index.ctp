<div class="temps index">
	<h2><?php __('Temps');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('datum');?></th>
			<th><?php echo $this->Paginator->sort('rainfall');?></th>
			<th><?php echo $this->Paginator->sort('tmin');?></th>
			<th><?php echo $this->Paginator->sort('tmax');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($temps as $temp):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $temp['Temp']['id']; ?>&nbsp;</td>
		<td><?php echo $temp['Temp']['datum']; ?>&nbsp;</td>
		<td><?php echo $temp['Temp']['rainfall']; ?>&nbsp;</td>
		<td><?php echo $temp['Temp']['tmin']; ?>&nbsp;</td>
		<td><?php echo $temp['Temp']['tmax']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $temp['Temp']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $temp['Temp']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $temp['Temp']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $temp['Temp']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Temp', true), array('action' => 'add')); ?></li>
	</ul>
</div>