<div class="phenotypes form">
<?php if (isset($phenotypes)) { echo $this->element('raws/related', array('phenotypes' => $phenotypes['Phenotype'])); } ?>
<?php echo $this->Form->create('Phenotype', array('url' => $this->params['named']));?>
	<fieldset>
        <legend><?php 
            if (isset($this->data['PhenotypeRaw']['raw_id']) && $this->data['PhenotypeRaw']['raw_id']) {
                __('Upload <em>next</em> scanner file');
            }
            else {
                __('Upload scanner file');
            }
        ?></legend>
	<?php
        echo $this->Form->hidden('Phenotype.program_id');
        echo $this->Form->hidden('Culture.experiment_id');
        echo $this->Form->hidden('Plant.culture_id');
        echo $this->Form->hidden('Form.posted');
        echo $this->Form->hidden('PhenotypeRaw.raw_id');

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
<div class="submit">
    <?php if (isset($this->data['PhenotypeRaw'])): # only show the stop button when we actually have something to stop with ?>
    <div class="actions" style="float: right"><ul><li>
    <?php echo $this->Html->link(__('Stop', true), array('controller' => 'raws', 'action'=>'view', $this->data['PhenotypeRaw']['raw_id'])); ?>
    </li></ul></div>
    <?php endif ?>
    <?php echo $this->Form->end(array('value' => __('Submit', true), 'div' => false)); ?>
</div>
</div>
