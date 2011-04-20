<div class="phenotypeEntities view">
<h2><?php  __('Phenotype Entity');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeEntity['PhenotypeEntity']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeEntity['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeEntity['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Entity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeEntity['Entity']['name'], array('controller' => 'entities', 'action' => 'view', $phenotypeEntity['Entity']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Entities', true), array('action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Phenotype Entity', true), array('action' => 'edit', $phenotypeEntity['PhenotypeEntity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Entity', true), array('action' => 'delete', $phenotypeEntity['PhenotypeEntity']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeEntity['PhenotypeEntity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Entity', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Entities', true), array('controller' => 'entities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Entity', true), array('controller' => 'entities', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
