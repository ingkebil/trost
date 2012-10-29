<div class="phenotypeSamples view">
<h2><?php  __('Phenotype Sample');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeSample['PhenotypeSample']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeSample['Sample']['id'], array('controller' => 'samples', 'action' => 'view', $phenotypeSample['Sample']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeSample['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeSample['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Phenotype Sample', true), array('action' => 'edit', $phenotypeSample['PhenotypeSample']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Sample', true), array('action' => 'delete', $phenotypeSample['PhenotypeSample']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeSample['PhenotypeSample']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Samples', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Sample', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
