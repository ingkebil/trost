<div class="raws index">
	<h2><?php __('Raws');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('date', 'Raw.date');?></th>
            <th># <?php __('lines'); ?></td>
            <th># <?php __('entities'); ?></td>
            <th># <?php __('values'); ?></td>
            <th># <?php __('bbches'); ?></td>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($raws as $raw):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $raw['Raw']['id']; ?>&nbsp;</td>
        <td><?php if (! empty($raw['Phenotype']['daterange']['mindate'])) {
            echo $raw['Phenotype']['daterange']['mindate']; 
            if ($raw['Phenotype']['daterange']['mindate'] != $raw['Phenotype']['daterange']['maxdate']) {
                echo ' > ';
                echo $raw['Phenotype']['daterange']['maxdate']; 
            }
        }
        else {
            echo __('No lines found', true);
        } ?>&nbsp;
        </td>
        <td><?php echo $raw['Phenotype']['count']['lines']; ?></td>
        <td><?php echo $raw['Phenotype']['count']['entity']; ?></td>
        <td><?php echo $raw['Phenotype']['count']['value']; ?></td>
        <td><?php echo $raw['Phenotype']['count']['bbch']; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $raw['Raw']['id'])); ?>
            <?php if ($this->Session->check('user')): ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $raw['Raw']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $raw['Raw']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $raw['Raw']['id'])); ?>
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
