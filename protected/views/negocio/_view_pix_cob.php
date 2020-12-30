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
		<button class="btn" type="button" onclick="criarPixCob()">Criar Cobrança PIX (F8)</button>
		<button class="btn" type="button" onclick="atualizaListagemPixCob()">Atualizar Listagem</button>
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
			<button class="btn" type="button" onclick="copiarBrCode()">Copiar BR Code</button>
			<button class="btn" type="button" onclick="consultarPixCob()">Consultar Pagamento</button>
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Cobrança PIX</h3>
	</div>
	<div class="modal-body">
		<div id="divPixCob">
			<div
			<div class="text-center">
				<div class="row-fluid">
					<div class="span4">
						<img id="pixCobQrcode" src="">
					</div>
					<div class="span8">
						<table class="detail-view table table-striped table-condensed" id="yw1">
							<tbody>
								<tr class="odd"><th>#</th><td id="pixCobCodpixcob"></td></tr>
								<tr class="even"><th>Status</th><td id="pixCobStatus"></td></tr>
								<tr class="odd"><th>TXID</th><td id="pixCobTxid"></td></tr>
								<tr class="even"><th>Valor</th><td id="pixCobValororiginal"></td></tr>
								<tr class="odd"><th>Portador</th><td id="pixCobPortador"></td></tr>
								<tr class="even">
									<th>BR Code</th>
									<td id="pixCobBrcode" style="word-break: break-all;">
										<textarea class="input-block-level" rows="4" readonly id="pixCobBrcodeTextArea" type="text"></textarea>
									</td>
								</tr>
							</tbody>
						</table>


					</div>
				</div>
				<br />
				<br />
				<br />
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

var pixCob = {}

function atualizaCamposPixCob ()
{
	$('#pixCobCodpixcob').html(pixCob.codpixcob);
	$('#pixCobStatus').html(pixCob.status);
	$('#pixCobTxid').html(pixCob.txid);
	$('#pixCobValororiginal').html(pixCob.valororiginal);
	if (pixCob.Portador != undefined) {
		$('#pixCobPortador').html(pixCob.Portador.portador);
	}
	$('#pixCobBrcodeTextArea').val(pixCob.brcode);
	$('#pixCobQrcode').attr('src', 'https://gerarqrcodepix.com.br/api/v1?tamanho=250&brcode=' + pixCob.brcode);
}

function consultarPixCob ()
{
	if (pixCob.codpixcob === undefined) {
		criarPixCob();
		return;
	}
	const codpixcob = pixCob.codpixcob;
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pix/cob/"+codpixcob+"/consultar",
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		pixCob = resp.data;
		atualizaCamposPixCob();
		$.notify("Cobrança " + resp.data.txid + " Consultada! Status: " + resp.data.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
	}).fail(function( jqxhr, textStatus, error ) {
		$.notify("Erro ao consultar cobrança "+ codpixcob +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function transmitirPixCob(codpixcob)
{
	$.ajax({
		type: 'POST',
		url: "<?php echo MGSPA_API_URL; ?>pix/cob/"+codpixcob+"/transmitir",
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		pixCob = resp.data;
		$.notify("Cobrança " + resp.data.txid + " Registrada! Status: " + resp.data.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		buscarBrCodePixCob(codpixcob);
	}).fail(function( jqxhr, textStatus, error ) {
		$.notify("Erro ao transmitir cobrança "+ codpixcob +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function criarPixCob()
{
	bootbox.confirm('Criar Cobrança via PIX?', function(result) {
		if (!result) {
			return
		}
		$.ajax({
		  type: 'POST',
		  url: "<?php echo MGSPA_API_URL; ?>pix/cob/criar-negocio/<?php echo $model->codnegocio ?>",
			dataType: "json",
		  headers: {
				"X-Requested-With":"XMLHttpRequest"
			},
		}).done(function(resp) {
			pixCob = resp.data;
			$.notify("Cobrança " + resp.data.txid + " Criada!", { position:"right bottom", className:"success"});
			transmitirPixCob(resp.data.codpixcob);
		}).fail(function( jqxhr, textStatus, error ) {
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
	$.ajax({
		url: "<?php echo MGSPA_API_URL ?>pix/cob/" + codpixcob,
		type: "GET",
		dataType: "json",
		async: false,
		success: function (data) {
			pixCob = data.data;
			atualizaCamposPixCob();
			$('#modalPixCob').modal({show:true});
			$('#modalPixCob').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao buscar BR Code da Cobrança PIX!");
		},
	});
}

$(document).ready(function() {
	$('#modalPixCob').on('hidden', function () {
		console.log('limpando pixCob = {}');
		pixCob = {};
	});
});

</script>
