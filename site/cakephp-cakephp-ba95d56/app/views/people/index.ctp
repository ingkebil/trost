<div class="people index">
	<h2><?php __('People');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('location_id');?></th>
			<th><?php echo $this->Paginator->sort('password');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($people as $person):
		$classes = array(); # the set of classes
        $class = ''; # the actial string represenation of the classes added to the tr-element
		if ($i++ % 2 == 0) {
			$classes[] = 'altrow';
		}
        if ($person['Person']['role'] == 'disabled') {
            $classes[] = 'disabled';
        }
        if ($classes) {
           $class = ' class="' . implode(" ", $classes) . '"';
        }
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $person['Person']['id']; ?>&nbsp;</td>
		<td><?php echo $person['Person']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($person['Location']['name'], array('controller' => 'locations', 'action' => 'view', $person['Location']['id'])); ?>
		</td>
		<td><?php echo $person['Person']['password']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $person['Person']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $person['Person']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $person['Person']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $person['Person']['id'])); ?>
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
