<div class="phenotypeBbches view">
<h2><?php  __('Phenotype Bbch');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phenotypeBbch['PhenotypeBbch']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phenotype'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeBbch['Phenotype']['id'], array('controller' => 'phenotypes', 'action' => 'view', $phenotypeBbch['Phenotype']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bbch'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($phenotypeBbch['Bbch']['name'], array('controller' => 'bbches', 'action' => 'view', $phenotypeBbch['Bbch']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phenotype Bbches', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('controller' => 'bbches', 'action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Phenotype Bbch', true), array('action' => 'edit', $phenotypeBbch['PhenotypeBbch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Phenotype Bbch', true), array('action' => 'delete', $phenotypeBbch['PhenotypeBbch']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phenotypeBbch['PhenotypeBbch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype Bbch', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bbch', true), array('controller' => 'bbches', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
