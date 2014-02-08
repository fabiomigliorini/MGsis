<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		//echo $form->textFieldRow($model,'codproduto',array('class'=>'span5'));
		echo $form->textFieldRow($model,'barras', array('class'=>'input-large','maxlength'=>50));
		echo $form->dropDownListRow($model, 'codprodutoembalagem', ProdutoEmbalagem::getListaCombo($model->codproduto), array('prompt' => $model->Produto->UnidadeMedida->sigla, 'class' => 'input-medium'));
		echo $form->textFieldRow($model,'variacao', array('class'=>'input-large','maxlength'=>100));
		echo $form->select2MarcaRow($model, 'codmarca');
		echo $form->textFieldRow($model,'referencia', array('class'=>'input-large','maxlength'=>50));
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

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/barcoder.js'); ?>

<script type='text/javascript'>
	
function validaGtin(codigo)
{
	
	console.log("-------");
	
	codigo = "000000000000000000" + codigo;
	codigo = codigo.substring(codigo.length-18, codigo.length);
	soma = 0;
	
	for (i = 1; i<codigo.length; i++)
	{
		digito = codigo.charAt(i-1);
		
		if (i === 0 || !!(i && !(i%2)))
			multiplicador = 1;
		else
			multiplicador = 3;
		
		console.log(i + ' = ' + digito + ' * ' + multiplicador);
		
		soma +=  digito * multiplicador;
	}
	
	console.log('soma ' + soma);	
}

$(document).ready(function() {

	//$("#Pessoa_fantasia").Setcase();

	$('#produto-barra-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	
	$('#ProdutoBarra_barras').keyup(function () {
		var codigo = $('#ProdutoBarra_barras').val();
		validaGtin(codigo);
	});
	/*
	$('#ProdutoBarra_barras').change(function () {
		var codigo = $('#ProdutoBarra_barras').val();
		var validator = new Barcoder('ean8');
		console.log(codigo);
		if (codigo.trim() == "" || validator.validate(codigo))
		{
			$("#ProdutoBarra_barras").popover('destroy');  
			return;
		}
		else
		{
			$("#ProdutoBarra_barras").popover({content: "Dígito Verificador Inválido!", trigger: 'manual'});  
			$("#ProdutoBarra_barras").popover('show');
		}
	});
	*/
});



</script>

