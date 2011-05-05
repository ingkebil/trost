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
