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

//http://www.gs1.org/barcodes/support/check_digit_calculator#how
function calculaDigitoGtin(codigo)
{
	//preenche com zeros a esquerda
	codigo = "000000000000000000" + codigo;
	
	//pega 18 digitos
	codigo = codigo.substring(codigo.length-18, codigo.length);
	soma = 0;
	
	//soma digito par *1 e impar *3
	for (i = 1; i<codigo.length; i++)
	{
		digito = codigo.charAt(i-1);
		if (i === 0 || !!(i && !(i%2)))
			multiplicador = 1;
		else
			multiplicador = 3;
		soma +=  digito * multiplicador;
	}
	
	//subtrai da maior dezena
	digito = (Math.ceil(soma/10)*10) - soma;	
	
	//retorna digitocalculado
	return digito;
}

//valida o codigo de barras 
function validaGtin(codigo)
{
	codigooriginal = codigo;
	codigo = codigo.replace(/[^0-9]/g, '');

	//se estiver em branco retorna verdadeiro
	if (codigo.length == 0) 
		return true;
		
	//se tiver letras no meio retorna false
	if (codigo.length != codigooriginal.length)
		return false;
	
	//se nao tiver comprimento adequado retorna false
	if ((codigo.length != 8) 
		&& (codigo.length != 12) 
		&& (codigo.length != 13) 
		&& (codigo.length != 14) 
		&& (codigo.length != 18))
		return false;

	//calcula digito e verifica se bate com o digitado
	digito = calculaDigitoGtin(codigo)
	if (digito == codigo.substring(codigo.length-1, codigo.length))
		return true;
	else
		return false;
}

function validaBarrasDigitado()
{
	//inicializa var
	var codigo = $('#ProdutoBarra_barras').val();
	
	//se estiver correto nao abre
	if (validaGtin(codigo) || (codigo.substring(0, 6) == '<?php echo str_replace('#', '',Yii::app()->format->formataCodigo($model->codproduto, 6)) ?>'))
		return true;
	else
		return false;
	
}

//mostra aviso sobre digito codigo de barras incorreto
function mostraPopoverBarras()
{
	var aberto = !($('#ProdutoBarra_barras').parent().find('.popover').length === 0);
	var abrir = !validaBarrasDigitado();
	
	//abre
	if (abrir && !aberto)
	{
		$("#ProdutoBarra_barras").popover({title: 'Dígito Verificador Inválido!', content: 'Verifique o códito digitado, ele não parece estar em nenhum dos padrões de código de barras, como GTIN, EAN ou UPC!', trigger: 'manual', placement: 'right'});  
		$("#ProdutoBarra_barras").popover('show');
	}
	
	//fecha
	if (!abrir && aberto)
	{
		$("#ProdutoBarra_barras").popover('destroy');  	
	}
	
}

function bootboxSalvar(currentForm)
{
	bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
		if (result) {
			currentForm.submit();
		}
	});	
}


$(document).ready(function() {

	$('#produto-barra-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
		if (!validaBarrasDigitado())
		{
			bootbox.confirm("O código de barras cadastrado parece estar incorreto, deseja mesmo continuar?", function(result) {
				if (result) {
					bootboxSalvar(currentForm);
				}
			});
		}
		else
			bootboxSalvar(currentForm);
    });
	
	$('#ProdutoBarra_barras').keyup(function () {
		mostraPopoverBarras();
	});
	
	mostraPopoverBarras();
});

</script>

