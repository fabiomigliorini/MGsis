<div class="control-group ">
	<label class="control-label" for="codformapagamento">
		<?php
			echo CHtml::image(
				Yii::app()->baseUrl . '/images/stone-logo.png',
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

			<button class="btn" type="button" onclick="abrirModalStone()">Criar Cobrança Stone (F9)</button>
			<button class="btn" type="button" onclick="atualizaListagemStonePreTransacao()">Atualizar Listagem</button>

		</div>
		<div id="listagemStonePreTransacao">
			<?php
			$this->renderPartial('_view_stone_listagem',
				array(
					'model'=>$model,
				));
			?>
		</div>
	</div>
</div>
<div class="modal hide fade" id="modalStone">
  <div class="modal-header">
		<?php
			echo CHtml::image(
				Yii::app()->baseUrl . '/images/stone-logo.png',
				'',
				array(
					'style' => 'max-width: 120px',
					'class'=>"",
				)
			);
		?>
  </div>
  <div class="modal-body">

		<div class="control-group ">
			<label class="control-label" for="stoneValor">Valor</label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on">R$</span>
					<input class="input-small text-right" maxlength="14" name="stoneValor" id="stoneValor" type="text">
				</div>
			</div>
		</div>

		<div class="control-group ">
			<label class="control-label" for="stoneTipo">Tipo</label>
			<!-- <div class="controls">
				<select name="stoneTipo" id="stoneTipo" class="input-small text-center">
				  <option value='1'>Debito</option>
				  <option value='2'>Crédito</option>
				  <option value='3'>Voucher</option>
				</select>
			</div> -->
			<div class="controls">
				<label class="radio">
				  <input type="radio" name="stoneTipo" id="stoneTipoDebito" value="1" checked>
				  Débito
				</label>
				<label class="radio">
				  <input type="radio" name="stoneTipo" id="stoneTipoCredito" value="2">
				  Crédito
				</label>
				<label class="radio">
				  <input type="radio" name="stoneTipo" id="stoneTipoCredito" value="3">
				  Voucher
				</label>
			</div>
		</div>

		<div class="control-group ">
			<label class="control-label" for="stoneParcelas">Parcelas</label>
			<div class="controls">
				<select name="stoneParcelas" id="stoneParcelas" class="input-mini text-center">
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
			<label class="control-label" for="codstonepos">Maquineta</label>
			<div class="controls">
				<?php foreach($model->Filial->StoneFilials[0]->StonePoss as $pos): ?>
					<label class="radio">
						<input type="radio" name="codstonepos" id="codstonepos" value="<?php echo $pos->codstonepos; ?>">
						<?php echo $pos->apelido; ?>
					</label>
				<?php endforeach; ?>
				<hr />
			</div>
		</div>

  </div>
  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-success" id="btnOkModalStone">OK (F9)</button>
	</div>
</div>
<script>

$('#btnOkModalStone').bind("click", function(e) {
	e.preventDefault();
	criarStonePreTransacao();
});

function copiarBrCode()
{
	const StonePreTransacaoBrcodeTextArea = document.querySelector("#StonePreTransacaoBrcodeTextArea");
	StonePreTransacaoBrcodeTextArea.select();
	document.execCommand('copy');
}

// window.StonePreTransacao = {}

<?php if (sizeof($model->StonePreTransacaos) > 0): ?>
window.StonePreTransacao = <?php echo json_encode($model->StonePreTransacaos[0]->attributes) ?>;
<?php else: ?>
window.StonePreTransacao = {};
<?php endif; ?>


function atualizaCamposStonePreTransacao ()
{
	$('#StonePreTransacaoCodStonePreTransacao').html(StonePreTransacao.codStonePreTransacao);
	$('#StonePreTransacaoStatus').html(StonePreTransacao.status);
	$('#StonePreTransacaoTxid').html(StonePreTransacao.txid);
	if (StonePreTransacao.valororiginal != undefined) {
		$('#StonePreTransacaoValororiginal').html(StonePreTransacao.valororiginal.toLocaleString('pt-br', {minimumFractionDigits: 2}));
	}
	if (StonePreTransacao.Portador != undefined) {
		$('#StonePreTransacaoPortador').html(StonePreTransacao.Portador.portador);
	}
	$('#StonePreTransacaoBrcode').html(StonePreTransacao.brcode);
	$('#StonePreTransacaoBrcodeTextArea').val(StonePreTransacao.brcode);
	if (StonePreTransacao.brcode != '' && StonePreTransacao.brcode != null) {
		$('#StonePreTransacaoQrcode').attr('src', 'https://gerarqrcodeStone.com.br/api/v1?tamanho=250&brcode=' + StonePreTransacao.brcode);
	} else {
		$('#StonePreTransacaoQrcode').attr('src', 'https://dummyimage.com/250x250/000000/fff.jpg&text=N%C3%A3o+Registrada!');
	}
}

window.rodandoStonePreTransacao = false;

function consultarStonePreTransacao (codStonePreTransacao)
{
	if (window.rodandoStonePreTransacao) {
		return
	}
	window.rodandoStonePreTransacao = true;
	$.ajax({
		type: 'GET',
		url: "<?php echo MGSPA_API_URL; ?>stone-connect/pre-transacao/"+codStonePreTransacao,
		dataType: "json",
		headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		verificarStatusNegocio();
		window.rodandoStonePreTransacao = false;
		$.notify("Cobrança " + resp.token + " Consultada! Status: " + resp.status, { position:"right bottom", className:"success", autoHideDelay: 15000 });
		atualizaListagemStonePreTransacao();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoStonePreTransacao = false;
		$.notify("Erro ao consultar cobrança "+ codStonePreTransacao +"!", { position:"right bottom", className:"error", autoHideDelay: 15000 });
		atualizaListagemStonePreTransacao();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function criarStonePreTransacao()
{
	if (window.rodandoStonePreTransacao) {
		return
	}
	var valor = parseFloat($('#stoneValor').autoNumeric('get'));
	var tipo = parseInt($("input:radio[name ='stoneTipo']:checked").val());
	// var tipo = parseInt($('#stoneTipo').val());
	var parcelas = parseInt($('#stoneParcelas').val());
	var codstonepos = parseInt($("input:radio[name ='codstonepos']:checked").val());
	if (isNaN(codstonepos)) {
		codstonepos = null;
		$.notify("Selecione a Maquineta!", { position:"right bottom", className:"error"});
		return;
	}
  console.log(valor);
  if (isNaN(valor) || valor <= 0) {
    $.notify("Preencha o valor!", { position:"right bottom", className:"error"});
    return;
  }

  
	$('#modalStone').modal('hide');

	window.rodandoStonePreTransacao = true;
	$.ajax({
	  type: 'POST',
	  url: "<?php echo MGSPA_API_URL; ?>stone-connect/pre-transacao",
		data: {
	    codstonefilial: <?php echo $model->Filial->StoneFilials[0]->codstonefilial; ?>,
	    valor: valor,
	    titulo: "Negocio <?php echo $model->codnegocio; ?>",
	    codnegocio: <?php echo $model->codnegocio; ?>,
	    codstonepos: codstonepos,
	    tipo: tipo,
	    parcelas: parcelas,
	    tipoparcelamento: 1
		},
		dataType: "json",
	  headers: {
			"X-Requested-With":"XMLHttpRequest"
		},
	}).done(function(resp) {
		window.rodandoStonePreTransacao = false;
		$.notify("Pre Transação Stone " + resp.token + " Criada!", { position:"right bottom", className:"success"});
		atualizaListagemStonePreTransacao();
	}).fail(function( jqxhr, textStatus, error ) {
		window.rodandoConsultaStonePreTransacao = false;
		$.notify("Erro ao Criar Cobrança via Stone!!", { position:"right bottom", className:"error"});
		atualizaListagemStonePreTransacao();
		var resp = jQuery.parseJSON(jqxhr.responseText);
		bootbox.alert(resp.message);
	});
}

function atualizaListagemStonePreTransacao()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('negocio/atualizalistagemStonePreTransacao') ?>",
		data: {
			codnegocio: <?php echo $model->codnegocio; ?>
		},
		type: "GET",
		dataType: "html",
		async: false,
		success: function (data) {
			$('#listagemStonePreTransacao').html(data);
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao atualizar listagem de cobranças Stone!");
		},
	});
}

function buscarBrCodeStonePreTransacao (codStonePreTransacao)
{
	$('#brCode').html('Carregando...');
	$('#qrCode').attr('src', '');
	abrirModalStonePreTransacao();
	$.ajax({
		url: "<?php echo MGSPA_API_URL ?>Stone/cob/" + codStonePreTransacao,
		type: "GET",
		dataType: "json",
		async: false,
		success: function (data) {
			window.StonePreTransacao = data.data;
			atualizaCamposStonePreTransacao();
		},
		error: function (xhr, status) {
			bootbox.alert("Erro ao buscar BR Code da Cobrança Stone!");
		},
	});
}

function abrirModalStone ()
{
	var valor = $('#valorpagamento').autoNumeric('get');
	$('#stoneValor').autoNumeric('set', valor);
	$('#stoneTipo').val(1);
	$('#stoneParcelas').val(1);
	$('#modalStone').modal({show:true, keyboard:true});
}

function acaoF9Stone ()
{
	if (!$('#modalStone').hasClass('in')) {
		abrirModalStone();
		return;
	}
	criarStonePreTransacao();
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
	$('#stoneValor').autoNumeric('init', {aSep:'.', aDec:',', altDec:'.' });

	$("input:radio[name='codstonepos']").change(function (){
		var codstonepos = parseInt($("input:radio[name ='codstonepos']:checked").val());
		setCookie('codstonepos', codstonepos);
		console.log(codstonepos);
		console.log('mudou pos');
	});

	var codstonepos = getCookie('codstonepos');
	$("input:radio[name='codstonepos'][value='"+ codstonepos +"']").attr('checked', true);

	console.log(codstonepos)

	$('#modalStone').on('shown', function (e) {
	    $('#stoneValor').focus();
	})
});

</script>
