<div class="people form">
<?php echo $this->Form->create('people', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('upload people file'); ?></legend>
        Needs a CSV file with following fields
        <ul>
        <li>id (ignored)</li>
        <li>name</li>
        <li>username</li>
        <li>email (domain used for location)</li>
        </ul>
        <br />
	<?php
        echo $this->Form->file('File.raw', array('label' => 'file upload'));
    ?>
	</fieldset>
<?php echo $this->Form->end(__('submit', true));?>
</div>
