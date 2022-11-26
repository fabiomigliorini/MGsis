<div class="control-group ">
	<div class="row-fluid" style="margin-bottom: 10px">
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
		<button class="btn" type="button" onclick="criarPixCob()">Criar PIX (F8)</button>
		<button class="btn" type="button" onclick="atualizaListagemPixCob()">Atualizar</button>
	</div>
	<div class="row-fluid">
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
			<button class="btn" type="button" onclick="imprimirQrCode()">
				<i class="icon-print"></i>
				Imprimir
			</button>
			<button class="btn" type="button" onclick="copiarMensagemComURLLandingPage()">
				<i class="icon-share"></i>
				Copiar Mensagem
			</button>
			<button class="btn" type="button" onclick="copiarQrCode()">
				<i class="icon-share"></i>
				Copiar QR Code
			</button>
			<button class="btn" type="button" onclick="consultarPixCobAberto()">
				<i class="icon-refresh"></i>
				Consultar (F8)
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
						<img id="pixCobQrCodeImg" style="min-width: 80%; max-height: 100%" >
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
									<th>QR Code</th>
									<td style="word-break: break-all;">
										<span id="pixCobQrCodeSpan"></span>
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

function copiarQrCode()
{
	navigator.clipboard.writeText(pixCob.qrcode);
}

function copiarMensagemComURLLandingPage()
{
	var mensagem = 'Olá,\n\n';
	mensagem += 'Você está recebendo um link para pagamento via PIX de sua compra na *MG Papelaria* no valor de R$ *' + pixCob.valororiginal.toLocaleString('pt-br', {minimumFractionDigits: 2}) + '*!\n\n';
	mensagem += 'Abra https://pix.mgpapelaria.com.br/' + pixCob.codpixcob + ' e siga as instruções:\n\n';
	mensagem += '*Obrigado* pela confiança!';
	navigator.clipboard.writeText(mensagem);
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
	$('#pixCobQrCodeSpan').html(pixCob.qrcode);
	var url = 'https://dummyimage.com/250x250/000000/fff.jpg&text=Carregando';
	if (pixCob.qrcodeimagem != '' && pixCob.qrcodeimagem != null) {
		url = pixCob.qrcodeimagem;
	} else if (pixCob.qrcode != '' && pixCob.qrcode != null) {
		url = 'https://chart.googleapis.com/chart?chs=513x513&cht=qr&chl=' + escape(pixCob.qrcode);
	}
	$('#pixCobQrCodeImg').attr('src', url);
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
	abrirModalPixCob();
	window.rodandoConsultaPixCob = true;
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

function imprimirQrCode ()
{
	if (pixCob.codpixcob === undefined) {
		return;
	}
	window.rodandoConsultaPixCob = true;
	var impressora = "<?php echo Yii::app()->user->getState('impressoraTermica') ?>";
	var codpixcob = pixCob.codpixcob;
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pix/cob/" + codpixcob + "/imprimir-qr-code",
		data: {
			impressora: impressora
		},
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		window.rodandoConsultaPixCob = false;
		$.notify("QR Code Impresso!", { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoConsultaPixCob = false;
		$.notify("Erro ao Imprimir QR Code!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
	});
}

function transmitirPixCob(codpixcob)
{
	abrirModalPixCob();
	window.rodandoConsultaPixCob = true;
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
		buscarQrCodePixCob(codpixcob);
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
	if (window.aguardandoConfirmacaoCriarPìxCob || window.rodandoConsultaPixCob) {
		return;
	}
	window.aguardandoConfirmacaoCriarPìxCob = true;
	bootbox.confirm('Criar Cobrança via PIX?', function(result) {
		abrirModalPixCob();
		window.pixCob = {};
		window.aguardandoConfirmacaoCriarPìxCob = false;
		if (!result) {
			return
		}
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

function buscarQrCodePixCob (codpixcob)
{
	abrirModalPixCob();
	$('#pixCobQrCodeSpan').html('Carregando...');
	$('#pixCobQrcodeImg').attr('src', '');
	$.ajax({
		url: "<?php echo MGSPA_API_URL ?>pix/cob/" + codpixcob + "/detalhes",
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
	$('#modalPixCob').modal({show:true});
	var height = $( window ).height();
	var bodyHeight = height*.96-100;
	$('#modalPixCob').css({'width': '96%', 'height': '96%', 'margin-left':'auto', 'margin-right':'auto', 'left':'2%', 'top': '2%'});
	$('#modalPixCobBody').css({'height': bodyHeight, 'max-height': bodyHeight, 'overflow-y': 'hidden'});
	atualizaCamposPixCob();
}

$(document).ready(function() {
	$('#modalPixCob').on('hidden', function () {
		// pixCob = {};
	});
});

</script>
