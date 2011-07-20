<div class="ufiles form">
<?php echo $this->Form->create('Ufile', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add file'); ?></legend>
	<?php
		echo $this->Form->input('submitter');
		echo $this->Form->input('description');
        echo $this->Form->input('Keyword'); // use the ModelName so multiple selection is possible
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
