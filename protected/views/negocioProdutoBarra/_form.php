<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'negocio-produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codnegocio',array('class'=>'span5'));
		echo $form->textFieldRow($model,'quantidade',array('class'=>'input-medium text-right','maxlength'=>14));
		echo $form->textFieldRow($model,'valorunitario',array('class'=>'input-medium text-right','maxlength'=>22));
		echo $form->textFieldRow($model,'valortotal',array('class'=>'input-medium text-right','maxlength'=>14));
		//echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5'));
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
	
function atualizaTotal (){
	$('#NegocioProdutoBarra_valortotal').autoNumeric('set',
		$('#NegocioProdutoBarra_quantidade').autoNumeric('get') * 
		$('#NegocioProdutoBarra_valorunitario').autoNumeric('get') 
	);
}
	
function atualizaUnitario (){
	if ($('#NegocioProdutoBarra_quantidade').autoNumeric('get') < 0.01)
		$('#NegocioProdutoBarra_quantidade').autoNumeric('set', 1);
	
	$('#NegocioProdutoBarra_valorunitario').autoNumeric('set',
		$('#NegocioProdutoBarra_valortotal').autoNumeric('get') /
		$('#NegocioProdutoBarra_quantidade').autoNumeric('get')  
	);
}

$(document).ready(function() {

	$("#NegocioProdutoBarra_quantidade").focus();
	$('#NegocioProdutoBarra_quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NegocioProdutoBarra_valorunitario').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:10 });
	$('#NegocioProdutoBarra_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NegocioProdutoBarra_quantidade').change(function() {
		atualizaTotal();
    });

	$('#NegocioProdutoBarra_valorunitario').change(function() {
		atualizaTotal();
    });
	
	$('#NegocioProdutoBarra_valortotal').change(function() {
		atualizaUnitario();
    });

	$('#negocio-produto-barra-form').submit(function(e) {
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
