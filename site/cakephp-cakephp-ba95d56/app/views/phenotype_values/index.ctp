<div class="phenotypeValues index">
	<h2><?php __('Phenotype Values');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('value_id');?></th>
			<th><?php echo $this->Paginator->sort('phenotype_id');?></th>
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phenotypeValues as $phenotypeValue):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $phenotypeValue['PhenotypeValue']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($phenotypeValue['Value']['attribute'], array('controller' => 'values', 'action' => 'view', $phenotypeValue['Value']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($phenotypeValue['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeValue['Phenotype']['id'])); ?>
		</td>
		<td><?php echo $phenotypeValue['PhenotypeValue']['number']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $phenotypeValue['PhenotypeValue']['id'])); ?>
            <?php if ($this->Session->check('user')): ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phenotypeValue['PhenotypeValue']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phenotypeValue['PhenotypeValue']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeValue['PhenotypeValue']['id'])); ?>
            <?php endif; ?>
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
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Values', true), array('controller' => 'values', 'action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('New Phenotype Value', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('New Value', true), array('controller' => 'values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
