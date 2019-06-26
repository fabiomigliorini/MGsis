<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'negocio-forma-pagamento-form',
        'type' => 'inline',
	
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codnegocio',array('class'=>'span5'));
		echo $form->select2(
			$model, 
			'codformapagamento', 
			FormaPagamento::getListaCombo(), 
			array(
				'placeholder'=>'Forma de Pagamento',
				'class' => 'input-xlarge'
			)
		);
	?>
	<?php
		echo $form->textField($model,'valorpagamento',array('class'=>'input-small text-right','maxlength'=>14));
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

	$('#NegocioFormaPagamento_valorpagamento').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#negocio-forma-pagamento-form').submit(function(e) {
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