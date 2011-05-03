<div class="raws view">
<h2><?php  __('Raw');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $raw['Raw']['id']; ?>
			&nbsp;
		</dd>
        <?php if ($this->Session->check('user')): ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $raw['Raw']['data']; ?>
			&nbsp;
		</dd>
        <?php endif; ?>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Raws', true), array('action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('Edit Raw', true), array('action' => 'edit', $raw['Raw']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Raw', true), array('action' => 'delete', $raw['Raw']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $raw['Raw']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('New Raw', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
<?php echo $this->element('raws/related', array('phenotypes' => $raw['Phenotype'])); ?>
