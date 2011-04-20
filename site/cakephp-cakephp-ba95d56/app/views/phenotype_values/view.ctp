<div class="phenotypeValues view">
<h2><?php  __('Phenotype Value');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeValue['PhenotypeValue']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeValue['Value']['id'], array('controller' => 'values', 'action' => 'view', $phenotypeValue['Value']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeValue['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeValue['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeValue['PhenotypeValue']['number']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Values', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Values', true), array('controller' => 'values', 'action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Phenotype Value', true), array('action' => 'edit', $phenotypeValue['PhenotypeValue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Value', true), array('action' => 'delete', $phenotypeValue['PhenotypeValue']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeValue['PhenotypeValue']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Value', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Value', true), array('controller' => 'values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
