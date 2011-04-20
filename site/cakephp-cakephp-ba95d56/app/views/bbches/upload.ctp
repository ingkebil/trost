<div class="bbches form">
<?php echo $this->Form->create('Bbch', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add BBCH codes'); ?></legend>
        <?php __('Column names:'); ?>
        <ul>
            <li><?php __('id'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('Name in German'); ?></li>
            <li><?php __('Name in English'); ?></li>
        </ul><br />
        <?php __('The BBCH codes will be saved in both English and German if possible'); ?>
	<?php
        echo $this->Form->file('File.raw', array('label' => 'File upload'));
        echo $this->Form->input('Bbch.species_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('controller' => 'phenotypes', 'action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bbches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Species', true), array('controller' => 'species', 'action' => 'index')); ?> </li>
        <?php if ($this->Session->check('user')): ?>
		<li><?php echo $this->Html->link(__('New Species', true), array('controller' => 'species', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
        <?php endif; ?>
	</ul>
</div>
