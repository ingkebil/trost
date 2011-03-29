<div class="entities form">
<?php echo $this->Form->create('Entity', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Entities'); ?></legend>
        <?php __('Column names:'); ?>
        <ul>
            <li><?php __('id'); ?></li>
            <li><?php __('name_en'); ?></li>
            <li><?php __('name_dt'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('unused column'); ?></li>
            <li><?php __('PO'); ?></li>
            <li><?php __('definition'); ?></li>
        </ul><br />
        <?php __('Entities will be saved in both English and German if possible'); ?>
	<?php
        echo $this->Form->file('File.raw', array('label' => 'File upload'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Entities', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
