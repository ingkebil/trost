<div class="values form">
<?php echo $this->Form->create('Value', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Values'); ?></legend>
        <?php __('Column names:'); ?>
        <ul>
            <li><?php __('ID'); ?></li>
            <li><?php __('Attribute in English'); ?></li>
            <li><?php __('Value in English'); ?></li>
            <li><?php __('Attribute in German'); ?></li>
            <li><?php __('Value in German'); ?></li>
        </ul><br />
        <?php __('The values will be saved in both English and German if possible'); ?>
	<?php
        echo $this->Form->file('File.raw', array('label' => 'File upload'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Values', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('controller' => 'phenotypes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phenotype', true), array('controller' => 'phenotypes', 'action' => 'add')); ?> </li>
	</ul>
</div>
