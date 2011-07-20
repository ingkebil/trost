<div class="ufiles index">
	<h2><?php __('Ufiles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('submitter');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th>Keywords</th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($ufiles as $ufile):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $ufile['Ufile']['submitter']; ?>&nbsp;</td>
		<td><?php echo $this->Html->link($ufile['Ufile']['name'], Configure::read('FileUpload.viewDir') . $ufile['Ufile']['submitter'] . DS . $ufile['Ufile']['name']); ?>&nbsp;</td>
        <td><?php 
            $keywords = array();
            foreach ($ufile['Keyword'] as $keyword) {
                $keywords[] = $keyword['name'];
            }
            echo implode(', ', $keywords);
        ?></td>
		<td><?php echo $ufile['Ufile']['created']; ?>&nbsp;</td>
		<td><?php echo $ufile['Ufile']['description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $ufile['Ufile']['id'])); ?>
            <?php if ($this->Session->check('user')): ?>
                <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $ufile['Ufile']['id'])); ?>
                <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $ufile['Ufile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ufile['Ufile']['id'])); ?>
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
