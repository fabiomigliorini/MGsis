<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-duplicatas-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
		echo $form->textFieldRow($model,'fatura',array('class'=>'input-medium','maxlength'=>20));

		echo $form->datepickerRow(
			$model, 
			'vencimento', 
			array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			)
		); 
		
		echo $form->textFieldRow($model,'valor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend'=>'R$'));
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
	$('#NotaFiscalDuplicatas_valor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#nota-fiscal-duplicatas-form').submit(function(e) {
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