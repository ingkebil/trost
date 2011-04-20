<div class="species view">
<h2><?php  __('Species');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $species['Species']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $species['Species']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('controller' => 'bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Species', true), array('action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Species', true), array('action' => 'edit', $species['Species']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Species', true), array('action' => 'delete', $species['Species']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $species['Species']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Species', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bbch', true), array('controller' => 'bbches', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Bbches');?></h3>
	<?php if (!empty($species['Bbch'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Bbch'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Species Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($species['Bbch'] as $bbch):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $bbch['id'];?></td>
			<td><?php echo $bbch['bbch'];?></td>
			<td><?php echo $bbch['name'];?></td>
			<td><?php echo $bbch['species_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'bbches', 'action' => 'view', $bbch['id'])); ?>
                <?php if ($this->Session->check('user')): ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'bbches', 'action' => 'edit', $bbch['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'bbches', 'action' => 'delete', $bbch['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $bbch['id'])); ?>
                <?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
