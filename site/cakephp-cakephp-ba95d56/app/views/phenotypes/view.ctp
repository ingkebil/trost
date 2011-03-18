<div class="phenotypes view">
<h2><?php  __('Phenotype');?></h2>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plant'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotype['Plant']['name'], array('controller' => 'plants', 'action' => 'view', $phenotype['Plant']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Phenotype', true), array('action' => 'edit', $phenotype['Phenotype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype', true), array('action' => 'delete', $phenotype['Phenotype']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotype['Phenotype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Programs', true), array('controller' => 'programs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program', true), array('controller' => 'programs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Attributes', true), array('controller' => 'phenotype_attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Attribute', true), array('controller' => 'phenotype_attributes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('controller' => 'phenotype_bbches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('controller' => 'phenotype_bbches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Entities', true), array('controller' => 'phenotype_entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('controller' => 'phenotype_entities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('controller' => 'phenotype_raws', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('controller' => 'phenotype_raws', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Phenotype Attributes');?></h3>
	<?php if (!empty($phenotype['PhenotypeAttribute'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Phenotype Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['PhenotypeAttribute'] as $phenotypeAttribute):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotypeAttribute['id'];?></td>
			<td><?php echo $phenotypeAttribute['attribute_id'];?></td>
			<td><?php echo $phenotypeAttribute['phenotype_id'];?></td>
			<td><?php echo $phenotypeAttribute['value'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotype_attributes', 'action' => 'view', $phenotypeAttribute['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotype_attributes', 'action' => 'edit', $phenotypeAttribute['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotype_attributes', 'action' => 'delete', $phenotypeAttribute['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeAttribute['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phenotype Attribute', true), array('controller' => 'phenotype_attributes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Phenotype Bbches');?></h3>
	<?php if (!empty($phenotype['PhenotypeBbch'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Phenotype Id'); ?></th>
		<th><?php __('Bbch Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['PhenotypeBbch'] as $phenotypeBbch):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotypeBbch['id'];?></td>
			<td><?php echo $phenotypeBbch['phenotype_id'];?></td>
			<td><?php echo $phenotypeBbch['bbch_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotype_bbches', 'action' => 'view', $phenotypeBbch['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotype_bbches', 'action' => 'edit', $phenotypeBbch['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotype_bbches', 'action' => 'delete', $phenotypeBbch['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeBbch['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('controller' => 'phenotype_bbches', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Phenotype Entities');?></h3>
	<?php if (!empty($phenotype['PhenotypeEntity'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Phenotype Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['PhenotypeEntity'] as $phenotypeEntity):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotypeEntity['id'];?></td>
			<td><?php echo $phenotypeEntity['phenotype_id'];?></td>
			<td><?php echo $phenotypeEntity['entity_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotype_entities', 'action' => 'view', $phenotypeEntity['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotype_entities', 'action' => 'edit', $phenotypeEntity['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotype_entities', 'action' => 'delete', $phenotypeEntity['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeEntity['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('controller' => 'phenotype_entities', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Phenotype Raws');?></h3>
	<?php if (!empty($phenotype['PhenotypeRaw'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Phenotype Id'); ?></th>
		<th><?php __('Raw Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($phenotype['PhenotypeRaw'] as $phenotypeRaw):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $phenotypeRaw['id'];?></td>
			<td><?php echo $phenotypeRaw['phenotype_id'];?></td>
			<td><?php echo $phenotypeRaw['raw_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'phenotype_raws', 'action' => 'view', $phenotypeRaw['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'phenotype_raws', 'action' => 'edit', $phenotypeRaw['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'phenotype_raws', 'action' => 'delete', $phenotypeRaw['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeRaw['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('controller' => 'phenotype_raws', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
