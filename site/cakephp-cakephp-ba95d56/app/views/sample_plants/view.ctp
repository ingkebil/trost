<div class="samplePlants view">
<h2><?php  __('Sample Plant');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $samplePlant['SamplePlant']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sample'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($samplePlant['Sample']['id'], array('controller' => 'samples', 'action' => 'view', $samplePlant['Sample']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plant'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($samplePlant['Plant']['name'], array('controller' => 'plants', 'action' => 'view', $samplePlant['Plant']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sample Plant', true), array('action' => 'edit', $samplePlant['SamplePlant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Sample Plant', true), array('action' => 'delete', $samplePlant['SamplePlant']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $samplePlant['SamplePlant']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sample Plants', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample Plant', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Samples', true), array('controller' => 'samples', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sample', true), array('controller' => 'samples', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Plants', true), array('controller' => 'plants', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plant', true), array('controller' => 'plants', 'action' => 'add')); ?> </li>
	</ul>
</div>
