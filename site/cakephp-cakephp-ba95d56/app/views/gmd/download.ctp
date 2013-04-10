<div class="gmd form">
<?php echo $this->Form->create('Gmd', array('url' => array('controller' => 'gmd', 'action' => 'download')));?>
	<fieldset>
 		<legend><?php __('Download From GMD'); ?></legend>
	<?php
		echo $this->Form->input('format', array('type' => 'select', 'options' => $formats));
		echo $this->Form->input('name',   array('type' => 'select', 'options' => $tags));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
