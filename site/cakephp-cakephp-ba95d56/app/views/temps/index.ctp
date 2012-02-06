<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
'); ?>
<div class="temps index">
	<h2><?php __('Temps');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('datum');?></th>
			<th><?php echo $this->Paginator->sort('precipitation');?></th>
			<th><?php echo $this->Paginator->sort('irrigation');?></th>
			<th><?php echo $this->Paginator->sort('tmin');?></th>
			<th><?php echo $this->Paginator->sort('tmax');?></th>
			<th><?php echo $this->Paginator->sort('location_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($temps as $temp):
        $class = array('row'.$temp['Temp']['id']);
        if ($i++ % 2 == 0) {
            $class[] = 'altrow';
        }
        if ($temp['Temp']['invalid'] == 1) {
            $class[] = 'invalid';
        }
        $class = implode(' ', $class);
        $class = " class='$class'";
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $temp['Temp']['id']; ?>&nbsp;</td>
		<td><?php echo $temp['Temp']['datum']; ?>&nbsp;</td>
		<td><?php echo str_replace('.', ',', $temp['Temp']['precipitation']); ?>&nbsp;</td>
		<td><?php echo str_replace('.', ',', $temp['Temp']['irrigation']); ?>&nbsp;</td>
		<td><?php echo str_replace('.', ',', $temp['Temp']['tmin']); ?>&nbsp;</td>
		<td><?php echo str_replace('.', ',', $temp['Temp']['tmax']); ?>&nbsp;</td>
		<td><?php echo $temp['Location']['name']; ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Ajax->link(
                __('Invalidate', true),
                array('controller' => 'temps', 'action' => 'invalidate', $temp['Temp']['id']),
                array('complete' => 'strike('.$temp['Temp']['id'].')'),
                sprintf(__('Are you sure you want to invalidate # %s?', true), $temp['Temp']['id'])
            ); ?>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $temp['Temp']['id'])); ?>
            <?php if ($this->Session->check('user')): ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $temp['Temp']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $temp['Temp']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $temp['Temp']['id'])); ?>
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
