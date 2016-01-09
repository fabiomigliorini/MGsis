<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.hotkeys.js');

?>
<script>
/*<![CDATA[*/

function enviarEmail(codnotafiscal, email, alterarcadastro, progresso, modelo)
{
	if (progresso)
	{
		$('#modalProgressoNfe').modal({show:true, keyboard:false})
		$('#modalProgressoNfeLabelStatus').text('Enviando NFe por E-mail...');
		$('#modalProgressoNfeProgressBar').css('width', '80%');
	}
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/enviarEmail')?>", 
		{ 
			codnotafiscal: codnotafiscal, 
			email: email,
			alterarcadastro: alterarcadastro,
		})
		.done(function(data) {

			if (progresso)
			{
				abrirDanfe(codnotafiscal, modelo, true, true);
			}
			else
			{
				var mensagem = formataMensagem(data);
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(mensagem);
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}


function consultarProtocoloNfe(codnotafiscal, modelo)
{
	
	$('#modalProgressoNfe').modal({show:true, keyboard:false})
	
	$('#modalProgressoNfeLabelStatus').text('Consultando Protocolo na Sefaz...');
	$('#modalProgressoNfeProgressBar').css('width', '70%');
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/consultarProtocolo')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			
			if (!data.retorno || data.cStat != 100)
			{
				var mensagem = formataMensagem(data);
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(mensagem, function() {
					location.reload();
				});
			}
			else
			{
				enviarEmail(codnotafiscal, '', 0, true, modelo);
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}

function enviarNfe(codnotafiscal, modelo)
{
	
	$('#modalProgressoNfe').modal({show:true, keyboard:false})
	
	$('#modalProgressoNfeLabelStatus').text('Enviando NFe para Sefaz...');
	$('#modalProgressoNfeProgressBar').css('width', '20%');
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/enviar')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			
			if (!data.retorno)
			{
				var mensagem = formataMensagem(data);
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(mensagem, function() {
					location.reload();
				});
			}
			else
			{
				
				$('#modalProgressoNfeLabelStatus').text('Aguardando processamento da Sefaz...');
				
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '25%');
				}, 500);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '30%');
				}, 1000);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '35%');
				}, 1500);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '40%');
				}, 2000);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '45%');
				}, 2500);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '50%');
				}, 3000);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '55%');
				}, 3500);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '60%');
				}, 4000);
				setTimeout(function(){ 
					$('#modalProgressoNfeProgressBar').css('width', '65%');
				}, 4500);
			
				//Aguarda 5 segundos para continuar
				setTimeout(function(){ 
					consultarProtocoloNfe(codnotafiscal, modelo);
				}, 5000);
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}


function criaXml(codnotafiscal, modelo)
{
	
	$('#modalProgressoNfe').modal({show:true, keyboard:false})
	
	$('#modalProgressoNfeLabelStatus').text('Criando Arquivo XML...');
	$('#modalProgressoNfeProgressBar').css('width', '0%');
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/criaXml')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			
			if (!data.retorno)
			{
				var mensagem = formataMensagem(data);
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(mensagem, function() {
					location.reload();
				});
			}
			else
			{
				console.log(modelo);
				if (data.tpEmis == <?php echo NotaFiscal::TPEMIS_OFFLINE; ?>)
					abrirDanfe(codnotafiscal, modelo, true, true);
				else
					enviarNfe(codnotafiscal, modelo);
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}


function abrirDanfe(codnotafiscal, modelo, recarregar, progresso)
{	
	if (progresso)
	{
		$('#modalProgressoNfe').modal({show:true, keyboard:false})
		$('#modalProgressoNfeLabelStatus').text('Processando Danfe...');
		$('#modalProgressoNfeProgressBar').css('width', '90%');
	}
	
	$('#btnImprimirNFCe').data('codnotafiscal', codnotafiscal);
	
	modelo = modelo || <?php echo NotaFiscal::MODELO_NFE ?>;
	recarregar = recarregar || true;
   
	$('#modalDanfe').modal({show:true})
	$('#frameDanfe').attr("src", '<?php echo Yii::app()->createUrl('NFePHPNovo/gerarDanfe')?>&codnotafiscal=' + codnotafiscal);
	$('#modalDanfe').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	$('#modalDanfe').off('hide');
	
	if (modelo == <?php echo NotaFiscal::MODELO_NFE ?>)
		$('#btnImprimirNFCe').hide();
	else
		$('#btnImprimirNFCe').show();

	if (progresso)
	{
		$('#modalProgressoNfe').modal({show:true, keyboard:false})
		$('#modalProgressoNfeLabelStatus').text('Finalizado...');
		$('#modalProgressoNfeProgressBar').css('width', '100%');
		$('#modalProgressoNfe').modal('hide');
		if (modelo == <?php echo NotaFiscal::MODELO_NFCE; ?>)
			imprimirNFCe(codnotafiscal);
	}

	if (recarregar)
		$('#modalDanfe').on('hide', function(){
			location.reload();
		});
}


function inutilizarNfe(codnotafiscal)
{
	bootbox.prompt("Digite a justificativa para inutilizar a NFE!", "Desistir", "OK", function(result) { 
		if (result === null)
			return;

		//$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/inutilizarNfe')?>", 
		$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/inutilizar')?>", 
			{ 
				codnotafiscal: codnotafiscal,
				justificativa: result 
			})
			.done(function(data) {

				var mensagem = formataMensagem(data);

				bootbox.alert(mensagem, function() {
					location.reload();
				});

			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(error, function() {
					location.reload();
				});
			});
	});
	
}


function cancelarNfe(codnotafiscal)
{
	bootbox.prompt("Digite a justificativa para cancelar a NFE!", "Desistir", "OK", function(result) { 
		if (result === null)
			return;

		//$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/cancelarNfe')?>", 
		$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/cancelar')?>", 
			{ 
				codnotafiscal: codnotafiscal,
				justificativa: result 
			} )
			.done(function(data) {

				var mensagem = formataMensagem(data);

				bootbox.alert(mensagem, function() {
					location.reload();
				});

			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(error, function() {
					location.reload();
				});
			});
	});
	
}

function consultarNfe (codnotafiscal)
{
	//$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/consultarNfe')?>", { id: codnotafiscal } )
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/consultar')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {

			var mensagem = formataMensagem(data);
			
			bootbox.alert(mensagem, function() {
				location.reload();
			});

		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
}


function formataMensagem(data)
{
	var mensagem = '';
	
	if (data.retorno)
		classe = 'alert alert-success';
	else
		classe = 'alert alert-error';
	
	if (data.xMotivo == null)
		data.xMotivo = 'Erro';
	
	mensagem += '<h3 class="' + classe + '">';

	if (data.cStat != null)
		mensagem += data.cStat + ' - ';
	
	mensagem += data.xMotivo + '</h3>';
	
	if (data.ex != null)
		mensagem += '<pre>' + data.ex + '</pre>';
	
	if (!$.isEmptyObject(data.aResposta))
		mensagem += 
			'<div class="accordion" id="accordion2"> ' +
			'  <div class="accordion-group"> ' +
			'	<div class="accordion-heading"> ' +
			'	  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> ' +
			'		Mostrar mais detalhes... ' +
			'	  </a> ' +
			'	</div> ' +
			'	<div id="collapseOne" class="accordion-body collapse"> ' +
			'	  <div class="accordion-inner"> ' +
			'		<pre>' + JSON.stringify(data.aResposta, null, '\t') + '</pre>' +
			'	  </div> ' +
			'	</div> ' +
			' </div> ' +
			'</div> ';

	return mensagem;
}


function perguntarEmail(codnotafiscal, email)
{
	bootbox.prompt("Digite o endereço de e-mail:", "Cancelar", "OK", function(result) { 
		if (result === null)
			return;

		if (result == email)
			enviarEmail(codnotafiscal, result, 0, false);
		else
		{
			bootbox.dialog("Alterar email do cadastro? <br><br> De <b class=\'text-error\'>" + email + "</b> <br><br> Para <b class=\'text-success\'>" + result + "</b>?", 
			[
				{
					"label" : "Não",
					"class" : "btn-danger",
					"callback": function() {
						enviarEmail(codnotafiscal, result, 0, false);
					}
				}, {
					"label" : "Sim",
					"class" : "btn-success",
					"callback": function() {
						email = result;
						enviarEmail(codnotafiscal, result, 1, false);
					}
				}
			]);

		}

	}, email);		
	
}

function imprimirNFCe (codnotafiscal)
{
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/imprimirNFCe')?>", 
		{ 
			codnotafiscal: codnotafiscal
		})
		.done(function(data) {
			if (data.retorno)
				$.notify('Documento enviado à impressora!', { position:"right bottom", className:"success"});
			else
				$.notify('Falha ao imprimir: "' + data.xMotivo + '"', { position:"right bottom", className:"error"});
		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}

$(document).ready(function(){

	$('#frameDanfe').attr("src", "about:blank");

	// ENVIAR NFE
	$('.btnEnviarNfe').on('click', function (e) {
		e.preventDefault();
		criaXml($(this).data('codnotafiscal'), $(this).data('modelo'));
	});
	
	//CONSULTAR NFE
	$('.btnConsultarNfe').on('click', function (e) {
		e.preventDefault();
		consultarNfe($(this).data('codnotafiscal'));
	});
	
	//CANCELAR NFE
	$('.btnCancelarNfe').on('click', function (e) {
		e.preventDefault();
		cancelarNfe($(this).data('codnotafiscal'));
	});
	
	//INUTILIZAR NFE
	$('.btnInutilizarNfe').on('click', function (e) {
		e.preventDefault();
		inutilizarNfe($(this).data('codnotafiscal'));
	});

	//abre janela vale
	$('.btnAbrirDanfe').click(function(e){
		e.preventDefault();
		abrirDanfe($(this).data('codnotafiscal'), $(this).data('modelo'), false, false);
	});	
	
	//imprimir Danfe Matricial
	$('#btnImprimirNFCe').click(function(e){
		e.preventDefault();
		imprimirNFCe($(this).data('codnotafiscal'));
	});
	
	$("*").bind('keydown.f9',function (e) { 
		e.preventDefault(); 
		$(".btnEnviarNfe:first").trigger( "click" );
		return false;
	});

	//enviar email
	$('.btnEnviarEmail').on('click', function (e) {
		e.preventDefault();
		perguntarEmail($(this).data('codnotafiscal'), $(this).data('email'));
	});
	
});
/*]]>*/
</script>
