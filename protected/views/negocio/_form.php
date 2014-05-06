<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'negocio-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
	
	// codfilial
	echo $form->select2Row($model, 'codfilial', Filial::getListaCombo(), array('prompt' => '', 'class' => 'input-medium'));
	
	echo $form->select2Row(
		$model, 
		'codnaturezaoperacao', 
		NaturezaOperacao::getListaCombo(), 
		array(
			//'placeholder'=>'Tributação',
			'class' => 'input-xlarge'
		)
	);
	
	// codpessoa
	echo $form->select2PessoaRow(
			$model, 
			'codpessoa'
			);
	
	// codpessoavendedor
	echo $form->select2PessoaRow(
			$model, 
			'codpessoavendedor',
			array('vendedor' => true)
			);
	
	echo $form->textFieldRow($model,'valorprodutos',array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true));
	echo $form->textFieldRow($model,'valordesconto',array('class'=>'input-small text-right','maxlength'=>14));
	echo $form->textFieldRow($model,'valortotal',array('class'=>'input-small text-right','maxlength'=>14, "readOnly"=>true));
	
	echo $form->textAreaRow($model,'observacoes',array('class'=>'input-xxlarge', 'rows'=>'5','maxlength'=>500));
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
	$('#Negocio_valorprodutos').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_codpessoa').select2('focus');
		
	$('#negocio-form').submit(function(e) {
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