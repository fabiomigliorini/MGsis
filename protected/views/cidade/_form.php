<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cidade-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'codestado',array('class'=>'span5'));
		echo $form->textFieldRow($model,'cidade',array('class'=>'span5','maxlength'=>50));
		echo $form->textFieldRow($model,'sigla',array('class'=>'span5','maxlength'=>3));
		echo $form->textFieldRow($model,'codigooficial',array('class'=>'span5'));
	?>
</fieldset>
<div class="form-actions">

    
    <?php 
	

        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Salvar',
                'icon' => 'icon-ok',
                )
            ); 
	?>
    
</div>

<?php $this->endWidget(); ?>
