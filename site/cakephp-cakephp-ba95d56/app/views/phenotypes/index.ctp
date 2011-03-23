<div class="phenotypes index">
	<h2><?php __('Phenotypes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('version');?></th>
			<th><?php echo $this->Paginator->sort('object');?></th>
			<th><?php echo $this->Paginator->sort('program_id');?></th>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('time');?></th>
			<th><?php echo $this->Paginator->sort('plant_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phenotypes as $phenotype):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $phenotype['Phenotype']['id']; ?>&nbsp;</td>
		<td><?php echo $phenotype['Phenotype']['version']; ?>&nbsp;</td>
		<td><?php echo $phenotype['Phenotype']['object']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($phenotype['Program']['name'], array('controller' => 'programs', 'action' => 'view', $phenotype['Program']['id'])); ?>
		</td>
		<td><?php echo $phenotype['Phenotype']['date']; ?>&nbsp;</td>
		<td><?php echo $phenotype['Phenotype']['time']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($phenotype['Plant']['name'], array('controller' => 'plants', 'action' => 'view', $phenotype['Plant']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $phenotype['Phenotype']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phenotype['Phenotype']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phenotype['Phenotype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotype['Phenotype']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Programs', true), array('controller' => 'programs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program', true), array('controller' => 'programs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('controller' => 'phenotype_bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('controller' => 'phenotype_bbches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Entities', true), array('controller' => 'phenotype_entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('controller' => 'phenotype_entities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('controller' => 'phenotype_raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('controller' => 'phenotype_raws', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Values', true), array('controller' => 'phenotype_values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Value', true), array('controller' => 'phenotype_values', 'action' => 'add')); ?> </li>
	</ul>
</div>