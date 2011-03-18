<div class="phenotypeRaws index">
	<h2><?php __('Phenotype Raws');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('phenotype_id');?></th>
			<th><?php echo $this->Paginator->sort('raw_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phenotypeRaws as $phenotypeRaw):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $phenotypeRaw['PhenotypeRaw']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($phenotypeRaw['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeRaw['Phenotype']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($phenotypeRaw['Raw']['id'], array('controller' => 'raws', 'action' => 'view', $phenotypeRaw['Raw']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $phenotypeRaw['PhenotypeRaw']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phenotypeRaw['PhenotypeRaw']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phenotypeRaw['PhenotypeRaw']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeRaw['PhenotypeRaw']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Raws', true), array('controller' => 'raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Raw', true), array('controller' => 'raws', 'action' => 'add')); ?> </li>
	</ul>
</div>