<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'cheque-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->textFieldRow($model,'cmc7',array('class'=>'input-xlarge','maxlength'=>50));
		echo $form->select2Row($model, 'codbanco', Banco::getListaCombo(), array('class' => 'input-xmini'));
		echo $form->textFieldRow($model,'agencia',array('class'=>'input-small','maxlength'=>10));
		echo $form->textFieldRow($model,'contacorrente',array('class'=>'input-small','maxlength'=>15));
		echo $form->textFieldRow($model,'emitente',array('class'=>'input-xlarge','xmaxlength'=>100));
		echo $form->textFieldRow($model,'numero',array('class'=>'input-small','maxlength'=>15));
		//echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		
		$op = array(
				'class' => 'input-small  text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			);
		echo $form->datepickerRow($model, 'emissao', $op);
		
		//echo $form->textFieldRow($model,'vencimento',array('class'=>'span5'));
		
		$op = 
		array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			);
		echo $form->datepickerRow($model, 'vencimento', $op); 
		
		//echo $form->textFieldRow($model,'repasse',array('class'=>'input-large'));
		
		$op = 
		array(
				'class' => 'input-small text-center', 
				'options' => array(
					'language' => 'pt',
					'format' => 'dd/mm/yyyy'
				),
				'prepend' => '<i class="icon-calendar"></i>',
			);
		echo $form->datepickerRow($model, 'repasse', $op); 
		
		echo $form->textFieldRow($model,'destino',array('class'=>'input-large','maxlength'=>50));
		echo $form->toggleButtonRow($model,'devolucao', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
		echo $form->textFieldRow($model,'motivodevolucao',array('class'=>'input-xlarge','maxlength'=>50));
		echo $form->textAreaRow($model,'observacao',array('class'=>'input-xlarge', 'rows'=>'5','maxlength'=>500));
		//echo $form->textFieldRow($model,'lancamento',array('class'=>'input-large'));
		//echo $form->textFieldRow($model,'cancelamento',array('class'=>'input-large'));
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

	$("#Cheque_destino").Setcase();
	$("#Cheque_emitente").Setcase();

	$('#Cheque_valor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
	$('#cheque-form').submit(function(e) {
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