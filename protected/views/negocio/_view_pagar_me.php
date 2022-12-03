<div class="bs-docs-example" style="margin-bottom: 10px">
	<div class="row-fluid">
		<?php
			echo CHtml::image(
				Yii::app()->baseUrl . '/images/pagar-me-logo.svg',
				'',
				array(
					'style' => 'max-width: 120px',
					'class'=> "logo-pagamento",
				)
			);
		?>
		<div class="pull-right">
			<button class="btn" type="button" onclick="abrirModalPagarMe()" tabindex="-1">Novo (F7)</button>
			<button class="btn" type="button" onclick="atualizaListagemPagarMePedido()" tabindex="-1">Atualizar</button>
		</div>
	</div>
	<div class="row-fluid">
		<div id="listagemPagarMePedido">
			<?php
			$this->renderPartial('_view_pagar_me_listagem',
				array(
					'model'=>$model,
				));
			?>
		</div>
	</div>
</div>
<div class="modal hide fade" id="modalPagarMe">
  <div class="modal-header">
		<?php
			echo CHtml::image(
				Yii::app()->baseUrl . '/images/pagar-me-logo.svg',
				'',
				array(
					'style' => 'max-width: 120px',
					'class'=>"",
				)
			);
		?>
  </div>
	<form id="formPagarMe">
  <div class="modal-body">

		<div class="control-group ">
			<label class="control-label" for="pagarMeValor">Valor</label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on">R$</span>
					<input class="input-small text-right pagar-me-enter" maxlength="14" name="pagarMeValor" id="pagarMeValor" type="text">
				</div>
			</div>
		</div>

		<div class="control-group ">
			<label class="control-label" for="pagarmeTipo">Tipo</label>
			<div class="controls">
				<label class="radio pagar-me-enter">
				  <input type="radio" name="pagarmeTipo" id="pagarmeTipoDebito" value="1" checked>
				  Débito
				</label>
				<label class="radio pagar-me-enter">
				  <input type="radio" name="pagarmeTipo" id="pagarmeTipoCredito" value="2">
				  Crédito
				</label>
				<label class="radio pagar-me-enter">
				  <input type="radio" name="pagarmeTipo" id="pagarmeTipoCredito" value="3">
				  Voucher
				</label>
			</div>
		</div>

		<div class="control-group ">
			<label class="control-label" for="pagarmeParcelas">Parcelas</label>
			<div class="controls">
				<select name="pagarmeParcelas" id="pagarmeParcelas" class="input-mini text-center pagar-me-enter">
				  <option>1</option>
				  <option>2</option>
				  <option>3</option>
				  <option>4</option>
				  <option>5</option>
				  <option>6</option>
				</select>
			</div>
		</div>

		<div class="control-group ">
			<label class="control-label" for="codpagarmepos">Maquineta</label>
			<div class="controls">
				<?php foreach($model->Filial->PagarMePoss as $pos): ?>
					<?php
					if (!empty($pos->inativo)) {
						continue;
					}
					?>
					<label class="radio pagar-me-enter">
						<input type="radio" name="codpagarmepos" id="codpagarmepos" value="<?php echo $pos->codpagarmepos; ?>">
						<?php echo $pos->Filial->filial ;?> -
						<?php echo $pos->serial; ?> -
						<?php echo $pos->apelido; ?>
					</label>
				<?php endforeach; ?>
				<hr />
			</div>
		</div>

  </div>
  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success" id="btnOkModalPagarMe">OK (F7)</button>
	</div>
	</form>
</div>
<script>

<?php if (sizeof($model->PagarMePedidos) > 0): ?>
window.PagarMePedido = <?php echo json_encode($model->PagarMePedidos[0]->attributes) ?>;
<?php else: ?>
window.PagarMePedido = {};
<?php endif; ?>


function atualizaCamposPagarMePedido ()
{
	$('#PagarMePedidoCodPagarMePedido').html(PagarMePedido.codPagarMePedido);
	$('#PagarMePedidoStatus').html(PagarMePedido.status);
	$('#PagarMePedidoTxid').html(PagarMePedido.txid);
	if (PagarMePedido.valororiginal != undefined) {
		$('#PagarMePedidoValororiginal').html(PagarMePedido.valororiginal.toLocaleString('pt-br', {minimumFractionDigits: 2}));
	}
	if (PagarMePedido.Portador != undefined) {
		$('#PagarMePedidoPortador').html(PagarMePedido.Portador.portador);
	}
	$('#PagarMePedidoBrcode').html(PagarMePedido.brcode);
	$('#PagarMePedidoBrcodeTextArea').val(PagarMePedido.brcode);
	if (PagarMePedido.brcode != '' && PagarMePedido.brcode != null) {
		$('#PagarMePedidoQrcode').attr('src', 'https://gerarqrcodePagarMe.com.br/api/v1?tamanho=250&brcode=' + PagarMePedido.brcode);
	} else {
		$('#PagarMePedidoQrcode').attr('src', 'https://dummyimage.com/250x250/000000/fff.jpg&text=N%C3%A3o+Registrada!');
	}
}

window.rodandoPagarMePedido = false;

function consultarPagarMePedido (codPagarMePedido)
{
	if (window.rodandoPagarMePedido) {
		return
	}
	window.rodandoPagarMePedido = true;
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pagar-me/pedido/"+codPagarMePedido+"/consultar",
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		verificarStatusNegocio();
		atualizaListagemPagamentos();
		window.rodandoPagarMePedido = false;
		$.notify("Cobrança " + resp.pedido.idpedido + " Consultado! Valor pago: " + resp.pedido.valorpagoliquido, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPagarMePedido();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoPagarMePedido = false;
		$.notify("Erro ao consultar cobrança "+ codPagarMePedido +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemPagarMePedido();
		atualizaListagemPagamentos();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function cancelarPagarMePedido (codPagarMePedido)
{
	if (window.rodandoPagarMePedido) {
		return
	}
	bootbox.confirm('Tem certeza que deseja cancelar?', function(result) {
		if (result)
		{
			window.rodandoPagarMePedido = true;
			$.ajax({
				type: 'DELETE',
				url: "<?php echo MGSPA_API_URL; ?>pagar-me/pedido/"+codPagarMePedido,
				dataType: "json",
				headers: {
					"X-Requested-With":"XMLHttpRequest"
				},
			}).done(function(resp) {
				verificarStatusNegocio();
				window.rodandoPagarMePedido = false;
				$.notify("Cobrança Cancelada! Status: " + resp.pedido.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
				atualizaListagemPagarMePedido();
			}).fail(function( jqxhr, textStatus, error ) {
				window.rodandoPagarMePedido = false;
				$.notify("Falha ao cancelar cobrança!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
				atualizaListagemPagarMePedido();
				var resp = jQuery.parseJSON(jqxhr.responseText);
				bootbox.alert(resp.message);
			});
		}
	});

}

function criarPagarMePedido()
{
	if (window.rodandoPagarMePedido) {
		return
	}
	var valor = parseFloat($('#pagarMeValor').autoNumeric('get'));
	var tipo = parseInt($("input:radio[name ='pagarmeTipo']:checked").val());
	// var tipo = parseInt($('#pagarmeTipo').val());
	var parcelas = parseInt($('#pagarmeParcelas').val());
	var codpagarmepos = parseInt($("input:radio[name ='codpagarmepos']:checked").val());
	if (isNaN(codpagarmepos)) {
		codpagarmepos = null;
		$.notify("Selecione a Maquineta!", { position:"right bottom", className:"error"});
		return;
	}
  if (isNaN(valor) || valor <= 0) {
    $.notify("Preencha o valor!", { position:"right bottom", className:"error"});
    return;
  }

	$('#modalPagarMe').modal('hide');

	window.rodandoPagarMePedido = true;
	var codpessoa = $('#Negocio_codpessoa').select2('val');
	var codfilial = $('#Negocio_codfilial').select2('val');

	$.ajax({
	  type: 'POST',
	  url: "<?php echo MGSPA_API_URL; ?>pagar-me/pedido",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>,
			codpessoa: codpessoa,
			codpagarmepos: codpagarmepos,
			valor: valor,
			tipo: tipo,
			parcelas: parcelas,
			jurosloja: 1,
			descricao: "Negocio <?php echo $model->codnegocio; ?>",
			codfilial: codfilial
		},
		dataType: "json",
	  headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		window.rodandoPagarMePedido = false;
		$.notify("Pre Transação PagarMe " + resp.token + " Criada!", { position:"right bottom", className:"success"});
		atualizaListagemPagarMePedido();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoConsultaPagarMePedido = false;
		$.notify("Erro ao Criar Cobrança via PagarMe!!", { position:"right bottom", className:"error"});
		atualizaListagemPagarMePedido();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function atualizaListagemPagarMePedido()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagemPagarMePedido') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: false,
		success: function (data) {
			$('#listagemPagarMePedido').html(data);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de cobranças PagarMe!");
		},
	});
}

function buscarBrCodePagarMePedido (codPagarMePedido)
{
	$('#brCode').html('Carregando...');
	$('#qrCode').attr('src', '');
	abrirModalPagarMePedido();
	$.ajax({
		url: "<?php echo MGSPA_API_URL ?>PagarMe/cob/" + codPagarMePedido,
		type: "GET",
		dataType: "json",
		async: false,
		success: function (data) {
			window.PagarMePedido = data.data;
			atualizaCamposPagarMePedido();
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao buscar BR Code da Cobrança PagarMe!");
		},
	});
}

function abrirModalPagarMe ()
{
	var valor = $('#valorpagamento').autoNumeric('get');
	$('#pagarMeValor').autoNumeric('set', valor);
	$('#pagarmeTipo').val(1);
	$('#pagarmeParcelas').val(1);
	$('#modalPagarMe').modal({show:true, keyboard:true});
}

function acaoF7PagarMe ()
{
	if (!$('#modalPagarMe').hasClass('in')) {
		abrirModalPagarMe();
		return;
	}
	criarPagarMePedido();
}

function setCookie(cname, cvalue) {
  document.cookie = cname + "=" + cvalue + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

$(document).ready(function() {

	$('.pagar-me-enter').keypress(function(e) {
    if (e.which == 13) {
			e.preventDefault();
			criarPagarMePedido();
    }
  });

	$('#pagarMeValor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$("input:radio[name='codpagarmepos']").change(function (){
		var codpagarmepos = parseInt($("input:radio[name ='codpagarmepos']:checked").val());
		setCookie('codpagarmepos', codpagarmepos);
	});

	var codpagarmepos = getCookie('codpagarmepos');
	$("input:radio[name='codpagarmepos'][value='"+ codpagarmepos +"']").attr('checked', true);

	$('#modalPagarMe').on('shown', function (e) {
	    $('#pagarMeValor').focus();
	});

	$('#modalPagarMe').on('hidden', function (e) {
	    setTimeout(function() {
					$('.modal-backdrop').remove();
	    }, 500); // meio segundo
	});

	$('#btnOkModalPagarMe').bind("click", function(e) {
		e.preventDefault();
		criarPagarMePedido();
	});

});

</script>
