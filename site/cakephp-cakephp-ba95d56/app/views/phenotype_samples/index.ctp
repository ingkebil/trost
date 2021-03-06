<div class="phenotypeSamples index">
	<h2><?php __('Phenotype Samples');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('sample_id');?></th>
			<th><?php echo $this->Paginator->sort('phenotype_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phenotypeSamples as $phenotypeSample):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $phenotypeSample['PhenotypeSample']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($phenotypeSample['Sample']['id'], array('controller' => 'samples', 'action' => 'view', $phenotypeSample['Sample']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($phenotypeSample['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeSample['Phenotype']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $phenotypeSample['PhenotypeSample']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phenotypeSample['PhenotypeSample']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phenotypeSample['PhenotypeSample']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeSample['PhenotypeSample']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Phenotype Sample', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>