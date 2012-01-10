<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
'); ?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<div class="ufiles index">
	<h2><?php __('Files');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort(__('Person', true), 'Person.name');?></th>
			<th><?php echo $this->Paginator->sort('Name');?></th>
            <th><?php __('Keywords') ?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($ufiles as $ufile):
        $class = array('row'.$ufile['Ufile']['id']);
        if ($i++ % 2 == 0) {
            $class[] = 'altrow';
        }
        if ($ufile['Ufile']['invalid'] == 1) {
            $class[] = 'invalid';
        }
        $class = implode(' ', $class);
        $class = " class='$class'";
	?>
	<tr<?php echo $class;?>>
        <td>
            <?php echo $ufile['Person']['name']; ?>&nbsp;
            <?php if (! empty($ufile['Person']['Location'])):
                echo '(' . $ufile['Person']['Location']['name'] . ')';
            endif; ?>
        </td>
		<td><?php echo $this->Html->link($ufile['Ufile']['name'], Configure::read('FileUpload.viewDir') . $ufile['Person']['name'] .$ufile['Person']['id'] . DS . $ufile['Ufile']['name']); ?>&nbsp;</td>
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
            <?php echo $this->Ajax->link(
                __('Invalidate', true),
                array('controller' => 'ufiles', 'action' => 'invalidate', $ufile['Ufile']['id']),
                array('complete' => 'strike('.$ufile['Ufile']['id'].')'),
                sprintf(__('Are you sure you want to invalidate # %s?', true), $ufile['Ufile']['id'])
            ); ?>
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
