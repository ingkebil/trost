<div class="ufiles form">
<?php echo $this->Form->create('Ufile', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add file'); ?></legend>
	<?php
        echo $this->Form->input('person_id', array('empty' => false));
		echo $this->Form->input('description');
        # if below line stops working: http://book.cakephp.org/view/1390/Automagic-Form-Elements#options-multiple-1395
        echo $this->Form->input('Keyword', array('empty' => false)); // use the ModelName so multiple selection is possible
        echo $this->Form->input('Ufile.new_keywords', array('label' => __('New Keywords (seperated by comma\'s)', true)));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
        echo $fileUpload->input(array('var' => 'file', 'model' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
