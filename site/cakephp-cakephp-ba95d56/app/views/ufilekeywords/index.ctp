<div class="ufilekeywords index">
	<h2><?php __('Ufilekeywords');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ufile_id');?></th>
			<th><?php echo $this->Paginator->sort('keyword_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($ufilekeywords as $ufilekeyword):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $ufilekeyword['Ufilekeyword']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ufilekeyword['Ufile']['id'], array('controller' => 'ufiles', 'action' => 'view', $ufilekeyword['Ufile']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ufilekeyword['Keyword']['id'], array('controller' => 'keywords', 'action' => 'view', $ufilekeyword['Keyword']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $ufilekeyword['Ufilekeyword']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $ufilekeyword['Ufilekeyword']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $ufilekeyword['Ufilekeyword']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufilekeyword['Ufilekeyword']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Ufilekeyword', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Ufiles', true), array('controller' => 'ufiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ufile', true), array('controller' => 'ufiles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords', true), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword', true), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>