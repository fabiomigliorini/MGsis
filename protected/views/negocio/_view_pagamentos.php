<div class="control-group ">
	<label class="control-label" for="codformapagamento">
		Pagamento
	</label>
	<div class="controls">
		<?php
		if ($model->codnegociostatus == 1)
		{
			?>
				<div class="row-fluid">
					<br>
					<?php
						$codformapagamento = FormaPagamento::DINHEIRO;
						if (!empty($model->codpessoa))
							if (!empty($model->Pessoa->codformapagamento))
								$codformapagamento = $model->Pessoa->codformapagamento;

						$this->widget(
							'booster.widgets.TbSelect2',
							array(
								'name' => 'codformapagamento',
								'value' => $codformapagamento,
								'data' => FormaPagamento::getListaCombo(),
								'options' => array (
									'allowClear'=>true,
								),
							)
						);
					?>
					&nbsp;
					<div class="input-append">
						<input class="input-small text-right" id="valorpagamento" type="text" value="1">
						<button class="btn" type="button" id="btnAdicionar" >Ok</button>
					</div>
				</div>
			<br>
			<?php
		}
		?>
		<div id="listagemPagamentos">
		<?php
		$this->renderPartial('_view_pagamentos_listagem',
			array(
				'model'=>$model,
			));
		?>
		</div>
		<span class="row-fluid" id="diferenca">
			<b class="span7" id="diferencalabel">
				Diferença
			</b>
			<b class="span4 text-right" id="diferencavalor">

			</b>
		</span>
	</div>
</div>
<script>

function atualizaListagemPagamentos()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagempagamentos') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: false,
		success: function (data) {
			$('#listagemPagamentos').html(data);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de pagamentos!");
		},
	});
}

function atualizaValorPagamento(foco)
{
	var valorpagamento = $("#totalvalorpagamento").val();
	var valortotal = $("#Negocio_valortotal").autoNumeric('get');
	var valordiferenca = valortotal - valorpagamento;

	$('#diferencavalor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	if (valordiferenca > 0)
	{
		$('#diferencalabel').html("Faltando");
		$('#diferencavalor').autoNumeric('set', Math.abs(valordiferenca));
		$('#valorpagamento').autoNumeric('set', Math.abs(valordiferenca));
		$('#diferenca').show()
		if (foco)
			$('#codformapagamento').select2('focus');
	}
	else
	{
		$('#valorpagamento').autoNumeric('set', 0);
		if (foco)
			$('.btn-primary').focus();
		if (valordiferenca < 0)
		{
			$('#diferencalabel').html("Troco");
			$('#diferencavalor').autoNumeric('set', Math.abs(valordiferenca));
			$('#diferenca').show()
		}
		else
			$('#diferenca').hide()
	}
}

function atualizaTela()
{
	atualizaListagemPagamentos();
	atualizaValorPagamento(true);
}

function adicionaFormaPagamento()
{
	var codformapagamento = $("#codformapagamento").val();
	var valorpagamento = $('#valorpagamento').autoNumeric('get');

	if (valorpagamento == 0)
		return false;

	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/adicionaformapagamento') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>,
			codformapagamento: codformapagamento,
			valorpagamento: valorpagamento,
		},
		type: "GET",
		dataType: "json",
		async: false,
		success: function(data) {
			if (!data.Adicionado)
			{
				bootbox.alert(data.Mensagem, function() {
								$("#codformapagamento").select2('focus');
							});
				$.notify("Erro ao Adicionar Pagamento", { className:"error" });
			}
			else
			{
				$.notify("Pagamento Adicionado!", { className:"success" });
				atualizaTela();
			}
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao adicionar produto!");
		},
	});
}

$(document).ready(function() {

	$('#valorpagamento').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });
	$('#Negocio_valortotal').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

    $("#btnAdicionar").click(function(e){
		e.preventDefault();
		adicionaFormaPagamento ();
	});

	atualizaValorPagamento();

	// botão delete da embalagem
	jQuery(document).on('click','a.delete-pagamento',function(e) {

		//evita redirecionamento da pagina
		e.preventDefault();

		// pega url para delete
		var url = jQuery(this).attr('href');

		//pede confirmacao
		bootbox.confirm("Excluir este Item?", function(result) {

			// se confirmou
			if (result) {

				//faz post
				jQuery.ajax({
					type: 'POST',
					url: url,

					//se sucesso, atualiza listagem de embalagens
					success: function(){
						atualizaTela();
					},

					//caso contrário mostra mensagem com erro
					error: function (XHR, textStatus) {
						var err;
						if (XHR.readyState === 0 || XHR.status === 0) {
							return;
						}
						//tipos de erro
						switch (textStatus) {
							case 'timeout':
								err = 'O servidor não responde (timed out)!';
								break;
							case 'parsererror':
								err = 'Erro de parâmetros (Parser error)!';
								break;
							case 'error':
								if (XHR.status && !/^\s*$/.test(XHR.status)) {
									err = 'Erro ' + XHR.status;
								} else {
									err = 'Erro';
								}
								if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
									err = err + ': ' + XHR.responseText;
								}
								break;
						}
						//abre janela do bootbox com a mensagem de erro
						if (err) {
							bootbox.alert(err);
						}
					}
				});
			}
		});
	});

});

</script>
