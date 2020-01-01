<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'nota-fiscal-produto-barra-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>

	<div class="tabbable"> <!-- Only required for left/right tabs -->
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tabProduto" data-toggle="tab">Produto</a></li>
	    <li class="hidden-phone"><a href="#tabLp" data-toggle="tab">Lucro Presumido</a></li>
	    <li class="hidden-phone"><a href="#tabPr" data-toggle="tab">Produtor Rural</a></li>
	    <li class="hidden-desktop"><a href="#tabLp" data-toggle="tab">Presumido</a></li>
	    <li class="hidden-desktop"><a href="#tabPr" data-toggle="tab">Rural</a></li>
	  </ul>
	  <div class="tab-content">

			<!-- PRODUTO -->
	    <div class="tab-pane active" id="tabProduto">
				<div class="row-fluid">
					<div class="span12" style="max-width: 90vw">
						<?php
							echo $form->select2ProdutoBarraRow($model,'codprodutobarra',array('class'=>'span12'));
						?>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'quantidade',array('class'=>'input-small text-right','maxlength'=>14));
							echo $form->textFieldRow($model,'valorunitario',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valortotal',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valordesconto',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valorfrete',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valorseguro',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valoroutras',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'valortotalfinal',array('class'=>'input-medium text-right','maxlength'=>14, 'prepend' => 'R$', 'disabled'=>true));
						?>
					</div>
					<div class="span7">
						<div class="row-fluid">
							<div class="span5">
								<?php
								echo $form->textFieldRow($model,'codcfop',array('class'=>'input-mini text-center'));
								echo $form->textFieldRow($model,'csosn',array('class'=>'input-mini text-center','maxlength'=>4));
								?>
							</div>
							<div class="span7">
								<?php
									echo $form->textFieldRow($model,'descricaoalternativa',array('class'=>'input-xlarge','maxlength'=>100));
									echo $form->textFieldRow($model,'pedido',array('class'=>'input-medium','maxlength'=>15));
									echo $form->textFieldRow($model,'pedidoitem',array('class'=>'input-mini text-right'));
								?>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span12">
								<?php
									echo $form->textAreaRow($model,'observacoes',array('class'=>'span12', 'rows'=>'11','maxlength'=>500));
								?>
							</div>
						</div>
					</div>
				</div>


	    </div>

			<!-- Lucro Presumido -->
	    <div class="tab-pane" id="tabLp">
				<div class="row-fluid">
					<div class="span3">
						<?php
						  echo $form->textFieldRow($model,'icmsbasepercentual',array('class'=>'input-small text-right','maxlength'=>6, 'prepend' => '%'));
							echo $form->textFieldRow($model,'icmsbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'icmspercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'icmsvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'icmscst',array('class'=>'input-mini text-center','maxlength'=>4));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'icmsstbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'icmsstpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'icmsstvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'ipibase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'ipipercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'ipivalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'ipicst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
				</div>

				<div class="row-fluid">
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'pisbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'pispercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'pisvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'piscst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'cofinsbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'cofinspercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'cofinsvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'cofinscst',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'csllbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'csllpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'csllvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'irpjbase',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'irpjpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
							echo $form->textFieldRow($model,'irpjvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
				</div>

	    </div>

			<!-- PRODUTOR RURAL -->
			<div class="tab-pane" id="tabPr">
				<div class="row-fluid">
					<div class="span3">
						<?php
							echo $form->toggleButtonRow($model,'certidaosefazmt', array('options' => array('enabledLabel' => 'Sim', 'disabledLabel' => 'Não')));
					 	?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span3">
						<?php
							echo $form->textFieldRow($model,'fethabkg',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
							echo $form->textFieldRow($model,'fethabvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
						echo $form->textFieldRow($model,'iagrokg',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						echo $form->textFieldRow($model,'iagrovalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
						echo $form->textFieldRow($model,'funruralpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
						echo $form->textFieldRow($model,'funruralvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
					<div class="span3">
						<?php
						echo $form->textFieldRow($model,'senarpercentual',array('class'=>'input-small text-right','maxlength'=>14, 'append' => '%'));
						echo $form->textFieldRow($model,'senarvalor',array('class'=>'input-small text-right','maxlength'=>14, 'prepend' => 'R$'));
						?>
					</div>
				</div>
			</div>

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

	var totalAntigo = $("#NotaFiscalProdutoBarra_valortotalfinal").data("previous-value");
	var totalNovo   = $("#NotaFiscalProdutoBarra_valortotalfinal").autoNumeric('get');

	atualizaBaseImposto ('icms', totalNovo, totalAntigo);
	atualizaBaseImposto ('icmsst', totalNovo, totalAntigo);
	atualizaBaseImposto ('ipi', totalNovo, totalAntigo);
	atualizaBaseImposto ('pis', totalNovo, totalAntigo);
	atualizaBaseImposto ('cofins', totalNovo, totalAntigo);
	atualizaBaseImposto ('csll', totalNovo, totalAntigo);
	atualizaBaseImposto ('irpj', totalNovo, totalAntigo);

	atualizaImposto ('funrural', 'percentual');
	atualizaImposto ('senar', 'percentual');

	atualizaImpostoKg ('fethab', 'kg');
	atualizaImpostoKg ('iagro', 'kg');

}

function atualizaBaseImposto (imposto, totalNovo, totalAntigo)
{
	var campobase = '#NotaFiscalProdutoBarra_' + imposto + 'base';
	var campopercentual = '#NotaFiscalProdutoBarra_' + imposto + 'percentual';

	var valorbase = $(campobase).autoNumeric('get');
	var valorpercentual = $(campopercentual).autoNumeric('get');

	if (valorbase <= 0 && valorpercentual <= 0) {
		return;
	}

	if (imposto == 'icms') {
		var campobasepercentual = '#NotaFiscalProdutoBarra_' + imposto + 'basepercentual';
		var valorbasepercentual = $(campobasepercentual).autoNumeric('get');
		valorbase = (totalNovo * valorbasepercentual)/100;
	} else {
		if (valorbase == totalAntigo || valorbase == 0) {
			valorbase = totalNovo;
		} else {
			valorbase = (totalNovo/totalAntigo) * valorbase;
		}
	}

	$(campobase).autoNumeric('set', valorbase);
	atualizaImposto(imposto, 'base');

}

function atualizaTotal ()
{
	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') *
		$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('get')
	);

	atualizaTotalFinal();
}

function atualizaUnitario ()
{
	if ($('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get') < 0.01)
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('set', 1);

	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('set',
		$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get') /
		$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('get')
	);
	atualizaTotalFinal();
}

function atualizaTotalFinal ()
{
	$("#NotaFiscalProdutoBarra_valortotalfinal").data("previous-value",
		$("#NotaFiscalProdutoBarra_valortotalfinal").autoNumeric('get')
	);

	console.log(Number($('#NotaFiscalProdutoBarra_valordesconto').autoNumeric('get')));
	console.log(Number($('#NotaFiscalProdutoBarra_valorfrete').autoNumeric('get')));
	console.log(Number($('#NotaFiscalProdutoBarra_valorseguro').autoNumeric('get')));
	console.log(Number($('#NotaFiscalProdutoBarra_valoroutras').autoNumeric('get')));

	$('#NotaFiscalProdutoBarra_valortotalfinal').autoNumeric('set',
		Number($('#NotaFiscalProdutoBarra_valortotal').autoNumeric('get'))
		- Number($('#NotaFiscalProdutoBarra_valordesconto').autoNumeric('get'))
		+ Number($('#NotaFiscalProdutoBarra_valorfrete').autoNumeric('get'))
		+ Number($('#NotaFiscalProdutoBarra_valorseguro').autoNumeric('get'))
		+ Number($('#NotaFiscalProdutoBarra_valoroutras').autoNumeric('get'))
	);

	atualizaBaseImpostos();
}


//atualiza imposto (icms/st/ipi) baseado no campo alterado (base/percentual/valor)
function atualizaImposto (imposto, campoalterado)
{
	var temBase = true;

	switch(imposto)
	{
		case 'funrural':
		case 'senar':
			temBase = false;
			break;
	}

	var campobase = '#NotaFiscalProdutoBarra_' + imposto + 'base';
	if (imposto == 'icms') {
		var campobasepercentual = '#NotaFiscalProdutoBarra_' + imposto + 'basepercentual';
	}
	var campopercentual = '#NotaFiscalProdutoBarra_' + imposto + 'percentual';
	var campovalor = '#NotaFiscalProdutoBarra_' + imposto + 'valor';

	var valorprodutos = $("#NotaFiscalProdutoBarra_valortotalfinal").autoNumeric('get');

	var base = (temBase)?$(campobase).autoNumeric('get'):valorprodutos;
	var basepercentual = (imposto == 'icms')?$(campobasepercentual).autoNumeric('get'):100;
	var percentual = $(campopercentual).autoNumeric('get');
	var valor = $(campovalor).autoNumeric('get');

	switch(campoalterado)
	{
		case 'basepercentual':
			if (basepercentual > 0) {
				base = (valorprodutos * basepercentual)/100;
			}

		case 'percentual':
			if (base == 0 && percentual > 0) {
				base = (valorprodutos * basepercentual)/100;
			}

		case 'base':
			valor = base * percentual / 100;
			break;

		case 'valor':
			percentual = 0;
			if (base == 0 && valor > 0) {
				base = valorprodutos;
			}
			if (base > 0 && valor > 0) {
				percentual = (valor / base) * 100;
			}
			break;

	}

	if (base == 0) { base = '' };
	if (percentual == 0) { percentual = '' };
	if (valor == 0) { valor = '' };

	if (temBase) {
		$(campobase).autoNumeric('set', base);
	}
	if (imposto == 'icms') {
		$(campobasepercentual).autoNumeric('set', basepercentual);
	}
	$(campopercentual).autoNumeric('set', percentual);
	$(campovalor).autoNumeric('set', valor);

}

function atualizaImpostoKg (imposto, campoalterado)
{

	var quantidade = $("#NotaFiscalProdutoBarra_quantidade").autoNumeric('get');

	var campokg = '#NotaFiscalProdutoBarra_' + imposto + 'kg';
	var campovalor = '#NotaFiscalProdutoBarra_' + imposto + 'valor';

	var kg = $(campokg).autoNumeric('get');
	var valor = $(campovalor).autoNumeric('get');

	switch(campoalterado)
	{
		case 'kg':
			valor = quantidade * kg;
			break;

		case 'valor':
			kg = 0;
			if (quantidade > 0 && valor > 0)
				kg = (valor / quantidade);
			break;

	}

	if (kg == 0) kg = '';
	if (valor == 0) valor = '';

	$(campokg).autoNumeric('set', kg);
	$(campovalor).autoNumeric('set', valor);

}

$(document).ready(function() {

	$("#NotaFiscalProdutoBarra_valortotalfinal").focus(function () {
		$(this).data("previous-value", $(this).autoNumeric('get'));
	});
	$("#NotaFiscalProdutoBarra_valortotalfinal").blur(function () {
		atualizaBaseImpostos();
	});



	//$("#Pessoa_fantasia").Setcase();
	$('#NotaFiscalProdutoBarra_pedidoitem').autoNumeric('init', {aSep:'', aDec:',', altDec:'.', mDec:0 });

	$('#NotaFiscalProdutoBarra_quantidade').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valorunitario').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:10 });
	$('#NotaFiscalProdutoBarra_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_valorfrete').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valorseguro').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valordesconto').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valoroutras').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_valortotalfinal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_icmsbase').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#NotaFiscalProdutoBarra_icmsbasepercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
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

	$('#NotaFiscalProdutoBarra_fethabkg').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:6 });
	$('#NotaFiscalProdutoBarra_fethabvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_iagrokg').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:6 });
	$('#NotaFiscalProdutoBarra_iagrovalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_funruralpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:5 });
	$('#NotaFiscalProdutoBarra_funruralvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_senarpercentual').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.', mDec:5 });
	$('#NotaFiscalProdutoBarra_senarvalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$('#NotaFiscalProdutoBarra_quantidade').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valorunitario').change(function() { atualizaTotal(); });
	$('#NotaFiscalProdutoBarra_valortotal').change(function() { atualizaUnitario(); });

	$('#NotaFiscalProdutoBarra_valordesconto').change(function() { atualizaTotalFinal(); });
	$('#NotaFiscalProdutoBarra_valorfrete').change(function() { atualizaTotalFinal(); });
	$('#NotaFiscalProdutoBarra_valorseguro').change(function() { atualizaTotalFinal(); });
	$('#NotaFiscalProdutoBarra_valoroutras').change(function() { atualizaTotalFinal(); });

	$('#NotaFiscalProdutoBarra_icmsbase').change(function() { atualizaImposto('icms', 'base'); });
	$('#NotaFiscalProdutoBarra_icmsbasepercentual').change(function() { atualizaImposto('icms', 'basepercentual'); });
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

	$('#NotaFiscalProdutoBarra_fethabkg').change(function() { atualizaImpostoKg('fethab', 'kg'); });
	$('#NotaFiscalProdutoBarra_fethabvalor').change(function() { atualizaImpostoKg('fethab', 'valor'); });

	$('#NotaFiscalProdutoBarra_iagrokg').change(function() { atualizaImpostoKg('iagro', 'kg'); });
	$('#NotaFiscalProdutoBarra_iagrovalor').change(function() { atualizaImpostoKg('iagro', 'valor'); });

	$('#NotaFiscalProdutoBarra_funruralpercentual').change(function() { atualizaImposto('funrural', 'percentual'); });
	$('#NotaFiscalProdutoBarra_funruralvalor').change(function() { atualizaImposto('funrural', 'valor'); });

	$('#NotaFiscalProdutoBarra_senarpercentual').change(function() { atualizaImposto('senar', 'percentual'); });
	$('#NotaFiscalProdutoBarra_senarvalor').change(function() { atualizaImposto('senar', 'valor'); });

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
