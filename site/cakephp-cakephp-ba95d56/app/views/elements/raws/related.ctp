<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
'); ?>
<div class="related">
	<h3><?php __('Related Phenotypes');?></h3>
	<?php if (!empty($phenotypes)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Program Id'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Time'); ?></th>
		<th><?php __('Plant'); ?></th>
		<th><?php __('Entity'); ?></th>
		<th><?php __('Attribute'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Number'); ?></th>
<?php if ($phenotypes[0]['program_id'] == 2): ?>
		<th><?php __('Bbch.name'); ?></th>
		<th><?php __('Bbch.id'); ?></th>
<?php endif ?>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotypes as $phenotype):
            $class = array('row'.$phenotype['id']);
            if (isset($lastinsertid) and $lastinsertid == $phenotype['id']) {
                $class[] = 'lastinsertrow';
            }
            elseif ($i++ % 2 == 0) {
                $class[] = 'altrow';
            }
            if ($phenotype['invalid'] == 1) {
                $class[] = 'invalid';
            }
            $class = implode(' ', $class);
            $class = " class='$class'";
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotype['id'];?></td>
			<td><?php echo $phenotype['program_id'];?></td>
			<td><?php echo $phenotype['date'];?></td>
			<td><?php echo $phenotype['time'];?></td>
			<td><?php echo $phenotype['Sample']['name'];?></td>
			<td><?php echo $phenotype['Entity'][0]['name'];?></td>
			<td><?php echo $phenotype['Value'][0]['attribute'];?></td>
			<td><?php echo $phenotype['Value'][0]['value'];?></td>
			<td><?php printf('%.3f', $phenotype['Value'][0]['PhenotypeValue']['number']);?></td>
<?php if ($phenotype['program_id'] == 2): ?>
			<td><?php echo $phenotype['Bbch'][0]['name'];?></td>
			<td><?php echo $phenotype['Bbch'][0]['bbch'];?></td>
<?php endif ?>
			<td class="actions">
                <?php echo $this->Ajax->link(
                    __('Invalidate', true),
                    array('controller' => 'phenotypes', 'action' => 'invalidate', $phenotype['id']),
                    array('complete' => 'strike('.$phenotype['id'].')'),
                    sprintf(__('Are you sure you want to invalidate # %s?', true), $phenotype['id'])
                ); ?>
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotypes', 'action' => 'view', $phenotype['id'])); ?>
                <?php if ($this->Session->check('user')): ?><?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotypes', 'action' => 'edit', $phenotype['id'])); ?>
            <?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotypes', 'action' => 'delete', $phenotype['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotype['id'])); ?><?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
