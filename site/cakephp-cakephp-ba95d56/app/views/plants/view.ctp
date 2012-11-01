<?php echo $javascript->link('jquery-1.5.1.min', false); ?>
<?php echo $javascript->codeBlock('
    function strike(id) {
        $(".row"+id).toggleClass("invalid");
    }
');

?>
<div class="plants view">
<h2><?php  __('Plant');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plant['Plant']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plant['Plant']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Culture'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($plant['Culture']['name'], array('controller' => 'cultures', 'action' => 'view', $plant['Culture']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Subspecies'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($plant['Subspecies']['id'], array('controller' => 'subspecies', 'action' => 'view', $plant['Subspecies']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plant['Plant']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lineid'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plant['Plant']['lineid']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $plant['Plant']['description']; ?>
			&nbsp;
		</dd>
	</dl>
	<h3><?php __('Related Phenotypes');?></h3>
	<?php if (!empty($plant['Phenotype'])):?>
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
		foreach ($plant['Phenotype'] as $phenotype):
			$class = array();
			if ($i++ % 2 == 0) {
				$class[] = '"altrow"';
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
			<td><?php echo $phenotype['Value']['attribute'] . ': '. $phenotype['Value']['value'];?></td>
			<td><?php echo $phenotype['number'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotypes', 'action' => 'view', $phenotype['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
	<h3><?php __('Related Samples');?></h3>
	<?php if (!empty($plant['Sample'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($plant['Sample'] as $sample):
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
