<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
'); ?>
<div class="samples view">
<h2><?php  __('Sample');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sample['Sample']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sample['Sample']['created']; ?>
			&nbsp;
		</dd>
	</dl>
	<h3><?php __('Related Phenotypes');?></h3>
	<?php if (!empty($sample['Phenotype'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Version'); ?></th>
		<th><?php __('Object'); ?></th>
		<th><?php __('Program'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Time'); ?></th>
		<th><?php __('Entity'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Number'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($sample['Phenotype'] as $phenotype):
			$class = array();
			if ($i++ % 2 == 0) {
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
			<td><?php echo $phenotype['version'];?></td>
			<td><?php echo $phenotype['object'];?></td>
			<td><?php echo $phenotype['Program']['name'];?></td>
			<td><?php echo $phenotype['date'];?></td>
			<td><?php echo $phenotype['time'];?></td>
			<td><?php echo $phenotype['Entity']['name'];?></td>
			<td><?php echo $phenotype['Value']['attribute'] . ': ' . $phenotype['Value']['value'];?></td>
			<td><?php echo $phenotype['number'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotypes', 'action' => 'view', $phenotype['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<h3><?php __('Related Plants');?></h3>
	<?php if (!empty($sample['Plant'])):?>
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
		foreach ($sample['Plant'] as $plant):
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
</div>
