<div class="raws view">
<h2><?php  __('Raw');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $raw['Raw']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?> style="overflow: scroll">
            <pre><?php echo $raw['Raw']['data']; ?> &nbsp;</pre>
		</dd>
	</dl>
    <?php echo $this->element('raws/related', array('phenotypes' => $raw['Phenotype'], 'programs' => $programs)); ?>
</div>
