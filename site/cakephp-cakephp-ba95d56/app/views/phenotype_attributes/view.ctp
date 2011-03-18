<div class="phenotypeAttributes view">
<h2><?php  __('Phenotype Attribute');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeAttribute['PhenotypeAttribute']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attribute'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeAttribute['Attribute']['name'], array('controller' => 'attributes', 'action' => 'view', $phenotypeAttribute['Attribute']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeAttribute['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeAttribute['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeAttribute['PhenotypeAttribute']['value']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Phenotype Attribute', true), array('action' => 'edit', $phenotypeAttribute['PhenotypeAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Attribute', true), array('action' => 'delete', $phenotypeAttribute['PhenotypeAttribute']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeAttribute['PhenotypeAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Attributes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Attribute', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Attributes', true), array('controller' => 'attributes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attribute', true), array('controller' => 'attributes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
