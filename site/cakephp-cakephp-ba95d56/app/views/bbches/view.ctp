<div class="bbches view">
<h2><?php  __('Bbch');?></h2>
    <div style="margin-bottom: 20px">
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bbch['Bbch']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Bbch'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bbch['Bbch']['bbch']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $bbch['Bbch']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Species'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($bbch['Species']['name'], array('controller' => 'species', 'action' => 'view', $bbch['Species']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
    </div>
    <?php echo $this->element('raws/related', array('phenotypes' => $bbch['Phenotype'])); ?>
</div>
