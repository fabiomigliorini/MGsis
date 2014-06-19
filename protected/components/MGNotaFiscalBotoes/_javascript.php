<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.hotkeys.js');

?>
<script>
/*<![CDATA[*/

function enviarNfe(codnotafiscal)
{
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/enviarNfe')?>", { id: codnotafiscal } )
		.done(function(data) {

			if (!data.resultado)
			{
				var mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				bootbox.alert(mensagem, function() {
					location.reload();
				});
			}
			else
			{
				if (data.resultadoEmail)
					$.notify("Email enviado para " + data.email + "!", "success");
			
				var botaoImprimir = false;
				
				if (data.modelo == <?php echo NotaFiscal::MODELO_NFCE; ?>)
					botaoImprimir = true;
					
				abrirJanelaDanfe(codnotafiscal, data.urlpdf, true, botaoImprimir);
				
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
}

function perguntarEmail(codnotafiscal, email)
{
	bootbox.prompt("Digite o endereço de e-mail:", "Cancelar", "OK", function(result) { 
		if (result === null)
			return;

		if (result == email)
			enviarEmail(codnotafiscal, result, 0);
		else
		{
			bootbox.dialog("Alterar email do cadastro? <br><br> De <b class=\'text-error\'>" + email + "</b> <br><br> Para <b class=\'text-success\'>" + result + "</b>?", 
			[
				{
					"label" : "Não",
					"class" : "btn-danger",
					"callback": function() {
						enviarEmail(codnotafiscal, result, 0);
					}
				}, {
					"label" : "Sim",
					"class" : "btn-success",
					"callback": function() {
						email = result;
						enviarEmail(codnotafiscal, result, 1);
					}
				}
			]);

		}

	}, email);		
	
}

function enviarEmail(codnotafiscal, email, alterarcadastro)
{
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/enviarEmail')?>", 
		{ 
			id: codnotafiscal, 
			email: email,
			alterarcadastro: alterarcadastro,
		})
		.done(function(data) {

			var mensagem = '';

			if (!data.resultado)
				mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
			else
			{
				mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';
			}
			
			bootbox.alert(mensagem, function () {
				if (alterarcadastro == 1)
					location.reload();
			});

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	
}

function abrirJanelaDanfe(codnotafiscal, urlpdf, recarregar, botaoImprimir)
{
	$('#modalDanfe').on('show', function () {
		$('#frameDanfe').attr("src", urlpdf);
	});
	$('#modalDanfe').modal({show:true})
	$('#modalDanfe').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
	
	$('#btnImprimirDanfePdfTermica').data('codnotafiscal', codnotafiscal);
	$('#modalDanfe').off('hide');
	
	if (botaoImprimir)
		$('#btnImprimirDanfePdfTermica').show();
	else
		$('#btnImprimirDanfePdfTermica').hide();
	
	if (recarregar)
		$('#modalDanfe').on('hide', function(){
			location.reload();
		});
		
}

function abrirDanfe(codnotafiscal, imprimir, botaoImprimir)
{	
	
	if (imprimir)
		imprimir = 1;
	else
		imprimir = 0;
	
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/imprimirDanfePdf')?>", 
		{ 
			id: codnotafiscal,
			imprimir: imprimir
		})
		.done(function(data) {

			var mensagem = '';

			if (!data.resultado)
			{
				mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				bootbox.alert(mensagem);
			}
			else
			{
				abrirJanelaDanfe(codnotafiscal, data.urlpdf, false, botaoImprimir);
			}

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
}

function cancelarNfe(codnotafiscal)
{
	bootbox.prompt("Digite a justificativa para cancelar a NFE!", "Desistir", "OK", function(result) { 
		if (result === null)
			return;

		$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/cancelarNfe')?>", 
			{ 
				id: codnotafiscal,
				justificativa: result 
			} )
			.done(function(data) {

				var mensagem = '';

				if (!data.resultado)
					mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				else
					mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';

				bootbox.alert(mensagem, function() {
					location.reload();
				});

			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
			});
	});
	
}

function inutilizarNfe(codnotafiscal)
{
	bootbox.prompt("Digite a justificativa para inutilizar a NFE!", "Desistir", "OK", function(result) { 
		if (result === null)
			return;

		$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/inutilizarNfe')?>", 
			{ 
				id: codnotafiscal,
				justificativa: result 
			})
			.done(function(data) {

				var mensagem = '';

				if (!data.resultado)
					mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
				else
					mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';

				bootbox.alert(mensagem, function() {
					location.reload();
				});

			})
			.fail(function( jqxhr, textStatus, error ) {
				var err = textStatus + ", " + error;
				console.log( "Request Failed: " + err );
			});
	});
	
}

function consultarNfe (codnotafiscal)
{
	$.getJSON("<?php echo Yii::app()->createUrl('notaFiscal/consultarNfe')?>", { id: codnotafiscal } )
		.done(function(data) {

			var mensagem = '';

			if (!data.resultado)
				mensagem = '<h3>' + data.erroMonitor + '</h3><pre>' + data.retorno + '</pre>';
			else
				mensagem = '<h3>' + data.retornoMonitor[1] + '</h3><pre>' + data.retorno + '</pre>';

			bootbox.alert(mensagem, function() {
				location.reload();
			});

		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
}

$(document).ready(function(){

	// ENVIAR NFE
	$('.btnEnviarNfe').on('click', function (e) {
		e.preventDefault();
		enviarNfe($(this).data('codnotafiscal'));
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
		var botaoImprimir = false;
		if ($(this).data('modelo') == "<?php echo NotaFiscal::MODELO_NFCE; ?>")
			botaoImprimir = true;
		abrirDanfe($(this).data('codnotafiscal'), false, botaoImprimir);
	});	
	
	//imprimir Danfe Matricial
	$('#btnImprimirDanfePdfTermica').click(function(e){
		e.preventDefault();
		abrirDanfe($(this).data('codnotafiscal'), true, true);
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
