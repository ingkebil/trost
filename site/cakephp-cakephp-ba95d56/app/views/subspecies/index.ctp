<div class="subspecies index">
	<h2><?php __('Subspecies');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('species_id');?></th>
			<th><?php echo $this->Paginator->sort('cultivar');?></th>
			<th><?php echo $this->Paginator->sort('breeder');?></th>
			<th><?php echo $this->Paginator->sort('reifegruppe');?></th>
			<th><?php echo $this->Paginator->sort('reifegrclass');?></th>
			<th><?php echo $this->Paginator->sort('krautfl');?></th>
			<th><?php echo $this->Paginator->sort('verwendung');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($subspecies as $subspecy):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $subspecy['Subspecy']['id']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['species_id']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['cultivar']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['breeder']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['reifegruppe']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['reifegrclass']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['krautfl']; ?>&nbsp;</td>
		<td><?php echo $subspecy['Subspecy']['verwendung']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $subspecy['Subspecy']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $subspecy['Subspecy']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $subspecy['Subspecy']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subspecy['Subspecy']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Subspecy', true), array('action' => 'add')); ?></li>
	</ul>
</div>