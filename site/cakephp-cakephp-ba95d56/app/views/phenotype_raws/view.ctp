<div class="phenotypeRaws view">
<h2><?php  __('Phenotype Raw');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeRaw['PhenotypeRaw']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeRaw['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeRaw['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Raw'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeRaw['Raw']['id'], array('controller' => 'raws', 'action' => 'view', $phenotypeRaw['Raw']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Line Nr'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeRaw['PhenotypeRaw']['line_nr']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Raws', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Raws', true), array('controller' => 'raws', 'action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Phenotype Raw', true), array('action' => 'edit', $phenotypeRaw['PhenotypeRaw']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Raw', true), array('action' => 'delete', $phenotypeRaw['PhenotypeRaw']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeRaw['PhenotypeRaw']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Raw', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Raw', true), array('controller' => 'raws', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
