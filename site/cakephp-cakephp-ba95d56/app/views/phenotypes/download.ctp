<?php if (isset($lines)): ?>
    <?php header('Content-type: text/text'); ?>
    <?php header("Content-Disposition: attachment; filename=$date_start-$date_end.txt"); ?>
    <?php if (isset($lines)) echo $lines; ?>
<?php else: ?>
<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Download'); ?></legend>
	<?php
		echo $this->Form->dateTime('date_start', 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false, 'default' => '2011-03-01 00:00'));
        echo '<br />';
		echo $this->Form->dateTime('date_end'  , 'DMY', 24, null, array('minYear' => 2011, 'maxYear' => date('Y'), 'empty' => false));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<?php endif ?>
