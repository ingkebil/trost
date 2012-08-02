<?php if (isset($lines)):
header('Content-type: text/text');
header("Content-Disposition: attachment; filename=$date_start-$date_end.txt");
echo $lines; ?><?php elseif (isset($zip_fn)):
header("Content-Type: application/zip");
header("Content-Length: " . filesize($zip_fn));
header('Content-Disposition: attachment; filename="phenotype_files.zip"');
readfile($zip_fn);
unlink($zip_fn);
else: ?>
<?php echo $this->Html->css('download', null, array('inline' => false));  ?>
<?php echo $this->Javascript->link('jquery-1.5.1.min',  false); ?>
<?php echo $this->Javascript->link('jquery.shiftclick', false); ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Download XML'); ?></legend>
        Download link between aliquots and plants in XML format.<br />
	<?php
		echo $this->Form->dateTime('date_start', 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false, 'default' => '2011-03-01 00:00'));
        echo '<br />';
		echo $this->Form->dateTime('date_end'  , 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('url' => array('blobsdate')));?>
	<fieldset>
 		<legend><?php __('Download Scanner Files'); ?></legend>
        Download the original scanner files.<br />
	<?php
		echo $this->Form->dateTime('date_start', 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false, 'default' => '2011-03-01 00:00'));
        echo '<br />';
		echo $this->Form->dateTime('date_end'  , 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype', array('url' => array('blobs')));?>
	<fieldset>
 		<legend><?php __('Download Scanner Files'); ?></legend>
        Download the original scanner files.<br />
	<?php
		echo $this->Form->input('files', array('type' => 'select', 'multiple' => 'checkbox', 'label' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<?php echo $this->Javascript->codeBlock('
    $(document).ready(function() {
        $("input[type=\'checkbox\']").shiftClick();
    });
'); ?>
<?php endif ?>
