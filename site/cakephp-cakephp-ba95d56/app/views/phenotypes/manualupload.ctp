<div class="phenotypes form">
<?php echo $this->Form->create('Phenotype');?>
	<fieldset>
 		<legend><?php __('Upload scanner file'); ?></legend>
	<?php
        echo $this->Form->hidden('Phenotype.program_id');
        echo $this->Form->hidden('Culture.experiment_id');
        echo $this->Form->hidden('Plant.culture_id');
        echo $this->Form->hidden('Form.posted');

        if ($this->data['Phenotype']['program_id'] == 1) {
            echo $this->element('phenotypes/fastscore');
        }
        else {
            echo $this->element('phenotypes/phenotyping');
        }
        echo $this->Form->label('Form.lastone', __('last one?', true));
        echo $this->Form->checkbox('Form.lastone');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload Scanner File', true), array('action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('Manual Input', true), array('action' => 'upload'));?></li>
		<li><?php echo $this->Html->link(__('List Phenotypes', true), array('action' => 'index'));?></li>
	</ul>
</div>
