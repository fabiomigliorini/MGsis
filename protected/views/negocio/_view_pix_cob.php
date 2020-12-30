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
			<button class="btn" data-dismiss="modal">Fechar</button>
		</div>
		<h3>Cobrança PIX</h3>
	</div>
	<div class="modal-body">
		<div id="divPixCob"></div>
      <!-- <iframe src="" id="framePixCob" name="framePixCob" width="99.6%" height="400" frameborder="0"></iframe> -->
	</div>
</div>
<script>

var pix = {}

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
		pix = resp.data;
		$.notify("Cobrança " + resp.data.txid + " Registrada! Status: " + resp.data.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemPixCob();
		mostrarQrCodePixCob(codpixcob);
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
			pix = resp.data;
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

function mostrarQrCodePixCob (codpixcob)
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/qrcodepixcob') ?>",
		data: {
			codpixcob: codpixcob
		},
		type: "GET",
		dataType: "html",
		async: false,
		success: function (data) {
			$('#divPixCob').html(data);
			$('#modalPixCob').modal({show:true})
			$('#modalPixCob').css({'width': '80%', 'min-height': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de cobranças PIX!");
		},
	});

	console.log(codpixcob);
}

$(document).ready(function() {

});

</script>
