<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'registro-spc-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codpessoa',array('class'=>'span5'));
		echo $form->select2PessoaRow($model, 'codpessoa' ,array('class'=>'span4'));
		//echo $form->textFieldRow($model,'inclusao',array('class'=>'span5'));
		echo $form->datepickerRow(
				$model,
				'inclusao',
				array(
					'class' => 'input-small text-center', 
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy'
						),
					'prepend' => '<i class="icon-calendar"></i>',
					)
				); 
		
		//echo $form->textFieldRow($model,'baixa',array('class'=>'span5'));
		echo $form->datepickerRow(
				$model,
				'baixa',
				array(
					'class' => 'input-small text-center', 
					'options' => array(
						'language' => 'pt',
						'format' => 'dd/mm/yyyy'
						),
					'prepend' => '<i class="icon-calendar"></i>',
					)
				);
		
		//echo $form->textFieldRow($model,'valor',array('class'=>'span2','maxlength'=>14));
		echo $form->textFieldRow($model,'valor',array('class'=>'input-small text-right','maxlength'=>14));
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

<script type='text/javascript'>
	
$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#registro-spc-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
});

</script>