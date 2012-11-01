<div class="phenotypes view">
<h2><?php  __('Phenotype');?></h2>
<?php if ($phenotype['Phenotype']['invalid'] == 1): ?>
<?php endif ?>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotype['Phenotype']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Version'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotype['Phenotype']['version']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Object'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotype['Phenotype']['object']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Program']['name'], array('controller' => 'programs', 'action' => 'view', $phenotype['Program']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotype['Phenotype']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Time'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotype['Phenotype']['time']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Connection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php if (array_key_exists(0, $phenotype['Sample'])):
                foreach ($phenotype['Sample'] as $sample): ?>
                    Sample:
                    <?php echo $this->Html->link($sample['id'], array('controller' => 'samples', 'action' => 'view', $sample['id'])); ?> 
                <?php endforeach;
            elseif (array_key_exists(0, $phenotype['Plant'])): ?>
                Plant:
			    <?php echo $this->Html->link($phenotype['Plant'][0]['id'], array('controller' => 'plants', 'action' => 'view', $phenotype['Plant'][0]['id']));?></td>
            <?php endif ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Entity']['name'], array('controller' => 'entities', 'action' => 'view', $phenotype['Entity']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attribute'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Value']['attribute'] .': '. $phenotype['Value']['value'], array('controller' => 'values', 'action' => 'view', $phenotype['Value']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php echo $phenotype['Phenotype']['number']; ?>
			&nbsp;
		</dd>
<?php if ($phenotype['Phenotype']['program_id'] == 2): ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('BBCH name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Bbch'][0]['name'], array('controller' => 'bbches', 'action' => 'view', $phenotype['Bbch'][0]['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('BBCH id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Bbch'][0]['bbch'], array('controller' => 'bbches', 'action' => 'view', $phenotype['Bbch'][0]['id'])); ?>
			&nbsp;
		</dd>
<?php endif ?>
	</dl>
	<h3><?php __('Related Plants');?></h3>
	<?php if (empty($phenotype['Plant'])):?>
    <?php __('None'); ?>
    <?php else: ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Culture Id'); ?></th>
		<th><?php __('Subspecies Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Lineid'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['Plant'] as $plant):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $plant['id'];?></td>
			<td><?php echo $plant['name'];?></td>
			<td><?php echo $plant['culture_id'];?></td>
			<td><?php echo $plant['subspecies_id'];?></td>
			<td><?php echo $plant['created'];?></td>
			<td><?php echo $plant['lineid'];?></td>
			<td><?php echo $plant['description'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'plants', 'action' => 'view', $plant['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
    <?php endif; ?>
	<h3><?php __('Related Samples');?></h3>
	<?php if (empty($phenotype['Sample'])):?>
    <?php __('None'); ?>
    <?php else: ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['Sample'] as $sample):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $sample['id'];?></td>
			<td><?php echo $sample['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'samples', 'action' => 'view', $sample['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
