<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<div class="row" style="max-width: 90vw">
		<?php
			//echo $form->textFieldRow($model,'codnotafiscal',array('class'=>'span5'));
			//echo $form->textFieldRow($model,'codprodutobarra',array('class'=>'span5'
			echo $form->select2ProdutoBarraRow($model,'codprodutobarra',array('class'=>'span12'));
		?>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php
				echo $form->textFieldRow($model,'quantidade',array('class'=>'input-small text-right','maxlength'=>14));
				echo $form->textFieldRow($model,'valorunitario',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'valortotal',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'descricaoalternativa',array('class'=>'span12','maxlength'=>100));
				echo $form->textFieldRow($model,'pedido',array('class'=>'input-medium','maxlength'=>15));
				echo $form->textFieldRow($model,'pedidoitem',array('class'=>'input-medium text-right'));
				echo $form->textFieldRow($model,'codcfop',array('class'=>'input-mini text-center'));
			?>
		</div>
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'icmsbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'icmspercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'icmsvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'icmscst',array('class'=>'input-mini text-center','maxlength'=>4));
				echo $form->textFieldRow($model,'csosn',array('class'=>'input-mini text-center','maxlength'=>4));
			?>
		</div>
		<div class="span2">

			<?php
				echo $form->textFieldRow($model,'icmsstbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'icmsstpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'ipibase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'ipipercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'ipivalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'ipicst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'pisbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'pispercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'pisvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'piscst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'cofinsbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'cofinspercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'cofinsvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'cofinscst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'csllbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'csllpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'csllvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
		<div class="span2">
			<?php
				echo $form->textFieldRow($model,'irpjbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
				echo $form->textFieldRow($model,'irpjpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
				echo $form->textFieldRow($model,'irpjvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
			?>
		</div>
	</div>
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

function atualizaBaseImpostos ()
{

	var totalAntigo = $("#NotaFiscalProdutoBarra_valortotal").data("previous-value");
	var totalNovo   = $("#NotaFiscalProdutoBarra_valortotal").autoNumeric('get');

	//var percentual = 0;

	atualizaBaseImposto ('icms', totalNovo, totalAntigo);
	atualizaBaseImposto ('icmsst', totalNovo, totalAntigo);
	atualizaBaseImposto ('ipi', totalNovo, totalAntigo);
	atualizaBaseImposto ('pis', totalNovo, totalAntigo);
	atualizaBaseImposto ('cofins', totalNovo, totalAntigo);
	atualizaBaseImposto ('csll', totalNovo, totalAntigo);
	atualizaBaseImposto ('irpj', totalNovo, totalAntigo);

	/*
	if (totalNovo > 0 && totalAntigo > 0)
	{
		percentual = totalNovo / totalAntigo;
	}

	console.log(percentual);

	if ($('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('get') > 0
		&& $('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('set', totalNovo);
		atualizaImposto('icms', 'base');
	}

	if ($('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('get') > 0
		&& $('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('set', totalNovo);
		atualizaImposto('icmsst', 'base');
	}

	if ($('#NotaFiscalProdutoBarra_ipibase').autoNumeric('get') > 0
		&& $('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('get') > 0)
	{
		$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('set', totalNovo);
		atualizaImposto('ipi', 'base');
	}
	*/
}

function atualizaBaseImposto (imposto, totalNovo, totalAntigo)
{
	var campobase = '#NotaFiscalProdutoBarra_' + imposto + 'base';
	var campopercentual = '#NotaFiscalProdutoBarra_' + imposto + 'percentual';

	var valorbase = $(campobase).autoNumeric('get');
	var valorpercentual = $(campopercentual).autoNumeric('get');

	if (valorbase <= 0 && valorpercentual <= 0)
		return;

	if (valorbase == totalAntigo || valorbase == 0)
		valorbase = totalNovo;
	else
	{
		valorbase = (totalNovo/totalAntigo) * valorbase;
	}

	$(campobase).autoNumeric('set', valorbase);
	atualizaImposto(imposto, 'base');

}

function atualizaTotal ()
{
	$("#NotaFiscalProdutoBarra_valortotal").data("previous-value",
		$("#NotaFiscalProdutoBarra_valortotal").autoNumeric('get')
	);

	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') *
		$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('get')
	);

	atualizaBaseImpostos ();
}

function atualizaUnitario ()
{
	if ($('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('set', 1);

	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get') /
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get')
	);
}


//atualiza imposto (icms/st/ipi) baseado no campo alterado (base/percentual/valor)
function atualizaImposto (imposto, campoalterado)
{
	var campobase = '#NotaFiscalProdutoBarra_' + imposto + 'base';
	var campopercentual = '#NotaFiscalProdutoBarra_' + imposto + 'percentual';
	var campovalor = '#NotaFiscalProdutoBarra_' + imposto + 'valor';

	/*
	switch(imposto)
	{

		case 'icms':
			campobase = '#NotaFiscalProdutoBarra_icmsbase';
			campopercentual = '#NotaFiscalProdutoBarra_icmspercentual';
			campovalor = '#NotaFiscalProdutoBarra_icmsvalor';
			break;

		case 'icmsst':
			campobase = '#NotaFiscalProdutoBarra_icmsstbase';
			campopercentual = '#NotaFiscalProdutoBarra_icmsstpercentual';
			campovalor = '#NotaFiscalProdutoBarra_icmsstvalor';
			break;

		case 'ipi':
			campobase = '#NotaFiscalProdutoBarra_ipibase';
			campopercentual = '#NotaFiscalProdutoBarra_ipipercentual';
			campovalor = '#NotaFiscalProdutoBarra_ipivalor';
			break;

		default:
			return false;

	}
	*/

	var base = $(campobase).autoNumeric('get');
	var percentual = $(campopercentual).autoNumeric('get');
	var valor = $(campovalor).autoNumeric('get');

	var valorprodutos = $("#NotaFiscalProdutoBarra_valortotal").autoNumeric('get');

	switch(campoalterado)
	{
		case 'percentual':
			if (base == 0 && percentual > 0)
				base = valorprodutos;

		case 'base':
			valor = base * percentual / 100;
			//if (base == 0)
			//	percentual = 0;
			break;

		case 'valor':
			percentual = 0;
			if (base == 0 && valor > 0)
				base = valorprodutos;
			if (base > 0 && valor > 0)
				percentual = (valor / base) * 100;
			break;

	}

	if (base == 0) base = '';
	if (percentual == 0) percentual = '';
	if (valor == 0) valor = '';

	$(campobase).autoNumeric('set', base);
	$(campopercentual).autoNumeric('set', percentual);
	$(campovalor).autoNumeric('set', valor);

}


$(document).ready(function() {

	$("#NotaFiscalProdutoBarra_valortotal").focus(function () {
		$(this).data("previous-value", $(this).autoNumeric('get'));
	});
	$("#NotaFiscalProdutoBarra_valortotal").blur(function () {
		atualizaBaseImpostos();
	});



	//$("#Pessoa_fantasia").Setcase();
	$('#NotaFiscalProdutoBarra_pedidoitem').autoNumeric('init', {aSep:'', aDec:',', altDec:'.', mDec:0 });

	$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmspercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_icmsstbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsstpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsstvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_ipibase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_ipipercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_ipivalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_pisbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_pispercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_pisvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_cofinsbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_cofinspercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_cofinsvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_csllbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_csllpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_csllvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_irpjbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_irpjpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_irpjvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_quantidade').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valorunitario').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valortotal').change(function() { atualizaUnitario(); });

	$('#NotaFiscalProdutoBarra_icmsbase').change(function() { atualizaImposto('icms', 'base'); });
	$('#NotaFiscalProdutoBarra_icmspercentual').change(function() { atualizaImposto('icms', 'percentual'); });
	$('#NotaFiscalProdutoBarra_icmsvalor').change(function() { atualizaImposto('icms', 'valor'); });

	$('#NotaFiscalProdutoBarra_icmsstbase').change(function() { atualizaImposto('icmsst', 'base'); });
	$('#NotaFiscalProdutoBarra_icmsstpercentual').change(function() { atualizaImposto('icmsst', 'percentual'); });
	$('#NotaFiscalProdutoBarra_icmsstvalor').change(function() { atualizaImposto('icmsst', 'valor'); });

	$('#NotaFiscalProdutoBarra_ipibase').change(function() { atualizaImposto('ipi', 'base'); });
	$('#NotaFiscalProdutoBarra_ipipercentual').change(function() { atualizaImposto('ipi', 'percentual'); });
	$('#NotaFiscalProdutoBarra_ipivalor').change(function() { atualizaImposto('ipi', 'valor'); });

	$('#NotaFiscalProdutoBarra_pisbase').change(function() { atualizaImposto('pis', 'base'); });
	$('#NotaFiscalProdutoBarra_pispercentual').change(function() { atualizaImposto('pis', 'percentual'); });
	$('#NotaFiscalProdutoBarra_pisvalor').change(function() { atualizaImposto('pis', 'valor'); });

	$('#NotaFiscalProdutoBarra_cofinsbase').change(function() { atualizaImposto('cofins', 'base'); });
	$('#NotaFiscalProdutoBarra_cofinspercentual').change(function() { atualizaImposto('cofins', 'percentual'); });
	$('#NotaFiscalProdutoBarra_cofinsvalor').change(function() { atualizaImposto('cofins', 'valor'); });

	$('#NotaFiscalProdutoBarra_csllbase').change(function() { atualizaImposto('csll', 'base'); });
	$('#NotaFiscalProdutoBarra_csllpercentual').change(function() { atualizaImposto('csll', 'percentual'); });
	$('#NotaFiscalProdutoBarra_csllvalor').change(function() { atualizaImposto('csll', 'valor'); });

	$('#NotaFiscalProdutoBarra_irpjbase').change(function() { atualizaImposto('irpj', 'base'); });
	$('#NotaFiscalProdutoBarra_irpjpercentual').change(function() { atualizaImposto('irpj', 'percentual'); });
	$('#NotaFiscalProdutoBarra_irpjvalor').change(function() { atualizaImposto('irpj', 'valor'); });


	$('#NotaFiscalProdutoBarra_codprodutobarra').change(function(e) {
		if ($("#NotaFiscalProdutoBarra_codprodutobarra").select2('data') != null)
		{
			console.log($("#NotaFiscalProdutoBarra_codprodutobarra").select2('data').preco);
			$("#NotaFiscalProdutoBarra_valorunitario").val(
				$("#NotaFiscalProdutoBarra_codprodutobarra").select2('data').preco
			);
			atualizaTotal ();
		}
	});

	$('#nota-fiscal-produto-barra-form').submit(function(e) {
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
