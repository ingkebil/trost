<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
'); ?>
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
			<th><?php echo $this->Paginator->sort('entity_id');?></th>
			<th><?php echo $this->Paginator->sort('value_id');?></th>
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phenotypes as $phenotype):
        $class = array('row'.$phenotype['Phenotype']['id']);
        if ($i++ % 2 == 0) {
            $class[] = 'altrow';
        }
        if ($phenotype['Phenotype']['invalid'] == 1) {
            $class[] = 'invalid';
        }
        $class = implode(' ', $class);
        $class = " class='$class'";
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
		<td><?php echo $this->Html->link($phenotype['Entity']['name'], array('controller' => 'entities', 'action' => 'view', $phenotype['Entity']['id']));?></td>
		<td><?php echo $this->Html->link($phenotype['Value']['attribute'] .': '. $phenotype['Value']['value'], array('controller' => 'entities', 'action' => 'view', $phenotype['Value']['id']));?></td>
		<td><?php echo $phenotype['Phenotype']['number'];?></td>
		<td class="actions">
            <?php echo $this->Ajax->link(
                __('Invalidate', true),
                array('controller' => 'phenotypes', 'action' => 'invalidate', $phenotype['Phenotype']['id']),
                array('complete' => 'strike('.$phenotype['Phenotype']['id'].')'),
                sprintf(__('Are you sure you want to invalidate # %s?', true), $phenotype['Phenotype']['id'])
            ); ?>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $phenotype['Phenotype']['id'])); ?>
            <?php if ($this->Session->check('user')): ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phenotype['Phenotype']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phenotype['Phenotype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotype['Phenotype']['id'])); ?>
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
