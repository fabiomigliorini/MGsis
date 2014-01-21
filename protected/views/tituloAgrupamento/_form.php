<?php $form=$this->beginWidget('MGActiveForm',array(
	'id'=>'titulo-agrupamento-form',
)); ?>

<?php echo $form->errorSummary($model); ?>

<fieldset>
	<?php 	
		echo $form->select2PessoaRow($model, 'codpessoa');
	?>
	<?php
	
		$html_titulos = '<div id="listagem-titulos">';
		
		$html_titulos .= 
			$this->widget(
				'MGGridTitulos', 
				array(
					'codpessoa' => $model->codpessoa,
					'codtitulos' => $model->codtitulos,
					'saldo' => $model->saldo,
					'multa' => $model->multa,
					'juros' => $model->juros,
					'desconto' => $model->desconto,
					'total' => $model->total,
				), 
				true
			);
		
		$html_titulos .= '</div>';
		
		echo $form->customRow($model, 'codtitulos', $html_titulos);
		/*
		echo $form->textFieldRow($model,'emissao',array('class'=>'span5'));
		echo $form->textFieldRow($model,'cancelamento',array('class'=>'span5'));
		echo $form->textFieldRow($model,'observacao',array('class'=>'span5','maxlength'=>200));
		* 
		*/
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
	<?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'reset',
                'label' => 'Limpar',
                'icon' => 'icon-refresh'
                )
            );
    ?>
    
</div>

<?php $this->endWidget(); ?>

<script type='text/javascript'>
	
function calculaTotalTitulo(campo)
{
	
	var idCampo = $(campo).attr('id');
	var arrCampo = idCampo.split('_');
	var codTitulo = arrCampo[2];
	var nomeCampoAlterado = arrCampo[1];
	
	campoSaldo = "#" + arrCampo[0] + '_saldo_' + codTitulo;
	campoMulta = "#" + arrCampo[0] + '_multa_' + codTitulo;
	campoJuros = "#" + arrCampo[0] + '_juros_' + codTitulo;
	campoDesconto = "#" + arrCampo[0] + '_desconto_' + codTitulo;
	campoTotal = "#" + arrCampo[0] + '_total_' + codTitulo;
	
	var valorSaldo = parseFloat($(campoSaldo).autoNumeric('get'));
	if (isNaN(valorSaldo))
		valorSaldo = 0;
	
	var valorMulta = parseFloat($(campoMulta).autoNumeric('get'));
	if (isNaN(valorMulta))
		valorMulta = 0;
	
	var valorJuros = parseFloat($(campoJuros).autoNumeric('get'));
	if (isNaN(valorJuros))
		valorJuros = 0;
	
	var valorDesconto = parseFloat($(campoDesconto).autoNumeric('get'));
	if (isNaN(valorDesconto))
		valorDesconto = 0;
	
	var valorTotal = parseFloat($(campoTotal).autoNumeric('get'));
	if (isNaN(valorTotal))
		valorTotal = 0;
	
	var valorSaldoCalculado = parseFloat($(campoSaldo).data('calculado'));
	if (isNaN(valorSaldoCalculado))
		valorSaldoCalculado = valorTotal;
	
	var valorMultaCalculado = parseFloat($(campoMulta).data('calculado'));
	if (isNaN(valorMultaCalculado))
		valorMultaCalculado = 0;
	
	var valorJurosCalculado = parseFloat($(campoJuros).data('calculado'));
	if (isNaN(valorJurosCalculado))
		valorJurosCalculado = 0;
	
	var valorDescontoCalculado = parseFloat($(campoDesconto).data('calculado'));
	if (isNaN(valorDescontoCalculado))
		valorDescontoCalculado = 0;
	
	var valorTotalCalculado = parseFloat($(campoTotal).data('calculado'));
	if (isNaN(valorTotalCalculado))
		valorTotalCalculado = valorTotal;
	
	if (nomeCampoAlterado == 'saldo')
	{
		var perc = 1;
		if (valorSaldo > valorSaldoCalculado)
		{
			valorSaldo = valorSaldoCalculado;
			perc = 1;
		}
		else
			perc = valorSaldo / valorSaldoCalculado;
		valorJuros = arredondar(valorJurosCalculado * perc, 2);
		valorMulta = arredondar(valorMultaCalculado * perc, 2);
		valorDesconto = arredondar(valorDescontoCalculado * perc, 2);
		
	} else if (nomeCampoAlterado == 'total')
	{
		var perc = 1;
		if (valorTotal > valorTotalCalculado)
		{
			valorTotal = valorTotalCalculado;
			perc = 1;
		}
		else
			perc = valorTotal / valorTotalCalculado;
		valorJuros = arredondar(valorJurosCalculado * perc, 2);
		valorMulta = arredondar(valorMultaCalculado * perc, 2);
		valorDesconto = arredondar(valorDescontoCalculado * perc, 2);
		valorSaldo = valorTotal - valorMulta - valorJuros + valorDesconto;
	}
	
	valorTotal = valorSaldo + valorMulta + valorJuros - valorDesconto;
	
	$(campoSaldo).autoNumeric('set', valorSaldo);
	$(campoMulta).autoNumeric('set', valorMulta);
	$(campoJuros).autoNumeric('set', valorJuros);
	$(campoDesconto).autoNumeric('set', valorDesconto);
	$(campoTotal).autoNumeric('set', valorTotal);
	
	$('#TituloAgrupamento_codtitulo_' + codTitulo).each(function() {
		$(this).attr('checked', true);
	});

	calculaTotais();
	
}

function calculaTotais()
{
	
	$('.numero').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	
	saldo = 0;
	multa = 0;
	juros = 0;
	desconto = 0;
	total = 0;
	
	$('.codtitulo:checked').each(function() {
		if ($("#TituloAgrupamento_operacao_" + $(this).val() ).val() == "CR")
			var multiplicador = -1;
		else
			var multiplicador = 1;
		
		if ($("#TituloAgrupamento_saldo_"    + $(this).val() ).autoNumeric('get') != "")
			saldo    += parseFloat($("#TituloAgrupamento_saldo_"    + $(this).val() ).autoNumeric('get')) * multiplicador;
		
		if ($("#TituloAgrupamento_multa_"    + $(this).val() ).autoNumeric('get') != "")
			multa    += parseFloat($("#TituloAgrupamento_multa_"    + $(this).val() ).autoNumeric('get')) * multiplicador;
		
		if ($("#TituloAgrupamento_juros_"    + $(this).val() ).autoNumeric('get') != "")
			juros    += parseFloat($("#TituloAgrupamento_juros_"    + $(this).val() ).autoNumeric('get')) * multiplicador;
		
		if ($("#TituloAgrupamento_desconto_"    + $(this).val() ).autoNumeric('get') != "")
			desconto -= parseFloat($("#TituloAgrupamento_desconto_" + $(this).val() ).autoNumeric('get')) * multiplicador;
		
		if ($("#TituloAgrupamento_total_"    + $(this).val() ).autoNumeric('get') != "")
			total    += parseFloat($("#TituloAgrupamento_total_"    + $(this).val() ).autoNumeric('get')) * multiplicador;
	});
	
	$('#total_saldo').autoNumeric('set', Math.abs(saldo));
	$('#total_multa').autoNumeric('set', Math.abs(multa));
	$('#total_juros').autoNumeric('set', Math.abs(juros));
	$('#total_desconto').autoNumeric('set', Math.abs(desconto));
	$('#total_total').autoNumeric('set', Math.abs(total));
	
}
	
function buscaTitulos()
{	
	//parametro codpessoa
	var params = [];
	params.push({name: 'codpessoa', value: $('#TituloAgrupamento_codpessoa').val()})
	
	//parametro para cada linha da grid
	$('.codtitulo:checked').each(function() {
		params.push({name: 'codtitulos[]', value: $(this).val()});
		params.push({name: 'saldo[' + $(this).val() + ']', value: $("#TituloAgrupamento_saldo_" + $(this).val() ).autoNumeric('get') });
		params.push({name: 'multa[' + $(this).val() + ']', value: $("#TituloAgrupamento_multa_" + $(this).val() ).autoNumeric('get') });
		params.push({name: 'juros[' + $(this).val() + ']', value: $("#TituloAgrupamento_juros_" + $(this).val() ).autoNumeric('get') });
		params.push({name: 'desconto[' + $(this).val() + ']', value: $("#TituloAgrupamento_desconto_" + $(this).val() ).autoNumeric('get') });
		params.push({name: 'total[' + $(this).val() + ']', value: $("#TituloAgrupamento_total_" + $(this).val() ).autoNumeric('get') });
	})
	
	//monta url
	if (params.length > 0)
	{
		var params_url = $.param(params);

		//atualiza div listagem-titulos
		$("#listagem-titulos").load("<?php echo Yii::app()->createUrl('titulo/ajaxbuscatitulo') ?>&" + params_url, function() {
			calculaTotais();
		});
	}
}
	
$(document).ready(function() {

	$('#titulo-agrupamento-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
        bootbox.confirm("Tem certeza que deseja salvar?", function(result) {
            if (result) {
                currentForm.submit();
            }
        });
    });
	$('#TituloAgrupamento_codpessoa').on("change", function(e) { 
		buscaTitulos();
	});
	calculaTotais();
	
	$('#TituloAgrupamento_codtitulo_todos').change(function(){
		$('.codtitulo').each(function() {
			$(this).attr('checked', $('#TituloAgrupamento_codtitulo_todos').is(':checked'));		
		});
		calculaTotais();
	});
	
	$('.codtitulo').change(function() {
		calculaTotais();
	});
	
	$('.numero').change(function(){
		calculaTotalTitulo(this);
	});
	
});

</script>