<div class="phenotypePlants view">
<h2><?php  __('Phenotype Plant');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypePlant['PhenotypePlant']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plant'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypePlant['Plant']['name'], array('controller' => 'plants', 'action' => 'view', $phenotypePlant['Plant']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypePlant['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypePlant['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Phenotype Plant', true), array('action' => 'edit', $phenotypePlant['PhenotypePlant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Plant', true), array('action' => 'delete', $phenotypePlant['PhenotypePlant']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypePlant['PhenotypePlant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Plants', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Plant', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
