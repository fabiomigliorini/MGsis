<div class="control-group ">
	<label class="control-label" for="codformapagamento">
		<?php
			echo CHtml::image(
				Yii::app()->baseUrl . '/images/pix-bc-logo.png',
				'',
				array(
					'style' => 'max-width: 120px',
					'class'=>"",
				)
			);
		?>
	</label>
	<div class="controls">
		<div style="margin-bottom: 20px">

			<button class="btn" type="button" onclick="criarPixCob()">Criar Cobrança PIX (F8)</button>
			<button class="btn" type="button" onclick="atualizaListagemPixCob()">Atualizar Listagem</button>

		</div>
		<div id="listagemPixCob">
			<?php
			$this->renderPartial('_view_pix_cob_listagem',
				array(
					'model'=>$model,
				));
			?>
		</div>
	</div>
</div>
<div id="modalPixCob" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<div class="pull-right">
			<button class="btn" type="button" onclick="copiarBrCode()">
				<i class="icon-share"></i>
				Copiar BR Code
			</button>
			<button class="btn" type="button" onclick="consultarPixCobAberto()">
				<i class="icon-refresh"></i>
				Consultar Pagamento (F8)
			</button>
			<button class="btn" type="button" onclick="transmitirPixCobAberto()">
				<i class="icon-upload"></i>
				Transmitir
			</button>
			<button class="btn" data-dismiss="modal">
				<i class="icon-remove"></i>
				Fechar
			</button>
		</div>
		<h3>Cobrança PIX</h3>
	</div>
	<div class="modal-body" id="modalPixCobBody">
		<div id="divPixCob">
			<div
			<div class="text-center">
				<div class="row-fluid">
					<div class="span6">
						<img id="pixCobQrcode" style="min-width: 80%; max-height: 100%" >
					</div>
					<div class="span5">
						<table class="detail-view table table-striped table-condensed" id="yw1">
							<tbody>
								<tr class="odd"><th>#</th><td id="pixCobCodpixcob"></td></tr>
								<tr class="even"><th>Status</th><td id="pixCobStatus"></td></tr>
								<tr class="odd"><th>TXID</th><td id="pixCobTxid"></td></tr>
								<tr class="even"><th>Valor</th><td id="pixCobValororiginal"></td></tr>
								<tr class="odd"><th>Portador</th><td id="pixCobPortador"></td></tr>
								<tr class="even">
									<th>BR Code</th>
									<td style="word-break: break-all;">
										<span class="hidden" id="pixCobBrcode"></span>
										<textarea class="input-block-level" readonly rows="4" id="pixCobBrcodeTextArea" type="text"></textarea>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

function copiarBrCode()
{
	const pixCobBrcodeTextArea = document.querySelector("#pixCobBrcodeTextArea");
	pixCobBrcodeTextArea.select();
	document.execCommand('copy');
}

// window.pixCob = {}

<?php if (sizeof($model->PixCobs) > 0): ?>
window.pixCob = <?php echo json_encode($model->PixCobs[0]->attributes) ?>;
<?php else: ?>
window.pixCob = {};
<?php endif; ?>


function atualizaCamposPixCob ()
{
	$('#pixCobCodpixcob').html(pixCob.codpixcob);
	$('#pixCobStatus').html(pixCob.status);
	$('#pixCobTxid').html(pixCob.txid);
	if (pixCob.valororiginal != undefined) {
		$('#pixCobValororiginal').html(pixCob.valororiginal.toLocaleString('pt-br', {minimumFractionDigits: 2}));
	}
	if (pixCob.Portador != undefined) {
		$('#pixCobPortador').html(pixCob.Portador.portador);
	}
	$('#pixCobBrcode').html(pixCob.brcode);
	$('#pixCobBrcodeTextArea').val(pixCob.brcode);
	if (pixCob.brcode != '' && pixCob.brcode != null) {
		$('#pixCobQrcode').attr('src', 'https://gerarqrcodepix.com.br/api/v1?tamanho=250&brcode=' + pixCob.brcode);
	} else {
		$('#pixCobQrcode').attr('src', 'https://dummyimage.com/250x250/000000/fff.jpg&text=N%C3%A3o+Registrada!');
	}
}

function criarConsultarPixCob ()
{
	if (window.rodandoConsultaPixCob) {
		return;
	}
	if (pixCob.codpixcob === undefined) {
		criarPixCob();
		return;
	}
	consultarPixCobAberto();
}

function consultarPixCobAberto ()
{
	if (!pixCob.codpixcob) {
		return;
	}
	consultarPixCob(pixCob.codpixcob);
}

function transmitirPixCobAberto ()
{
	if (!pixCob.codpixcob) {
		return;
	}
	transmitirPixCob(pixCob.codpixcob);
}

function consultarPixCob (codpixcob)
{
	window.rodandoConsultaPixCob = true;
	abrirModalPixCob();
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pix/cob/"+codpixcob+"/consultar",
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		verificarStatusNegocio();
		window.rodandoConsultaPixCob = false;
		window.pixCob = resp.data;
		atualizaCamposPixCob();
		$.notify("Cobrança " + resp.data.txid + " Consultada! Status: " + resp.data.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoConsultaPixCob = false;
		$.notify("Erro ao consultar cobrança "+ codpixcob +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function transmitirPixCob(codpixcob)
{
	window.rodandoConsultaPixCob = true;
	abrirModalPixCob();
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pix/cob/"+codpixcob+"/transmitir",
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		window.rodandoConsultaPixCob = false;
		window.pixCob = resp.data;
		$.notify("Cobrança " + resp.data.txid + " Registrada! Status: " + resp.data.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		buscarBrCodePixCob(codpixcob);
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoConsultaPixCob = false;
		$.notify("Erro ao transmitir cobrança "+ codpixcob +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function criarPixCob()
{
	console.log(window.aguardandoConfirmacaoCriarPìxCob);
	if (window.aguardandoConfirmacaoCriarPìxCob || window.rodandoConsultaPixCob) {
		return;
	}
	window.aguardandoConfirmacaoCriarPìxCob = true;
	bootbox.confirm('Criar Cobrança via PIX?', function(result) {
		window.pixCob = {};
		window.aguardandoConfirmacaoCriarPìxCob = false;
		if (!result) {
			return
		}
		abrirModalPixCob();
		window.rodandoConsultaPixCob = true;
		$.ajax({
		  type: 'POST',
		  url: "<?php echo MGSPA_API_URL; ?>pix/cob/criar-negocio/<?php echo $model->codnegocio ?>",
			dataType: "json",
		  headers: {
				"X-Requested-With":"XMLHttpRequest"
			},
		}).done(function(resp) {
			window.pixCob = resp.data;
			$.notify("Cobrança " + resp.data.txid + " Criada!", { position:"right bottom", className:"success"});
			transmitirPixCob(resp.data.codpixcob);
		}).fail(function( jqxhr, textStatus, error ) {
			window.rodandoConsultaPixCob = false;
			$.notify("Erro ao Criar Cobrança via PIX!!", { position:"right bottom", className:"error"});
			atualizaListagemPixCob();
			var resp = jQuery.parseJSON(jqxhr.responseText);
			bootbox.alert(resp.message);
		});
	});
}

function atualizaListagemPixCob()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagempixcob') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: false,
		success: function (data) {
			$('#listagemPixCob').html(data);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de cobranças PIX!");
		},
	});
}

function buscarBrCodePixCob (codpixcob)
{
	$('#brCode').html('Carregando...');
	$('#qrCode').attr('src', '');
	abrirModalPixCob();
	$.ajax({
		url: "<?php echo MGSPA_API_URL ?>pix/cob/" + codpixcob,
		type: "GET",
		dataType: "json",
		async: false,
		success: function (data) {
			window.pixCob = data.data;
			atualizaCamposPixCob();
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao buscar BR Code da Cobrança PIX!");
		},
	});
}

function abrirModalPixCob ()
{
	atualizaCamposPixCob();
	$('#modalPixCob').modal({show:true});
	var height = $( window ).height();
	var bodyHeight = height*.96-100;
	$('#modalPixCob').css({'width': '96%', 'height': '96%', 'margin-left':'auto', 'margin-right':'auto', 'left':'2%', 'top': '2%'});
	$('#modalPixCobBody').css({'height': bodyHeight, 'max-height': bodyHeight, 'overflow-y': 'hidden'});
}

$(document).ready(function() {
	$('#modalPixCob').on('hidden', function () {
		// pixCob = {};
	});
});

</script>