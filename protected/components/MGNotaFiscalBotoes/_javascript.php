<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.hotkeys.js');
require_once(Yii::app()->basePath . '/.env.php');

?>
<script>
/*<![CDATA[*/

function NFePHPErro (jqxhr)
{
	$('#modalProgressoNfe').modal('hide');
	if (resp = jQuery.parseJSON(jqxhr.responseText)) {
		var mensagem = resp.message;
	} else {
		var mensagem = 'Erro ao Acessar API';
	}
	mensagem = "<h3 class='text-error'>" + mensagem + "</h3>";
	bootbox.alert(mensagem, function() {
		location.reload();
	});
}

function NFePHPDanfe(codnotafiscal, modelo, recarregar)
{

	$('#modalProgressoNfeLabelStatus').text('Finalizado...');
	$('#modalProgressoNfeProgressBar').css('width', '100%');

	// NO CELULAR ABRE PDF
	if (/Mobi|Android/i.test(navigator.userAgent)) {

		var xhr = new XMLHttpRequest();
		xhr.open('GET', "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/danfe", true);
		xhr.responseType = 'blob';
		xhr.onload = function(e) {
		 if (this['status'] == 200) {
		   var blob = new Blob([this['response']], {type: 'application/pdf'});
		   var url = URL.createObjectURL(blob);
		   var printWindow = window.open(url);
			 if (recarregar) {
				 location.reload();
			 }
		 }
		};
		xhr.send();

	// NO COMPUTADOR ABRE MODAL
	}	else {

		$('#btnImprimirNFCe').data('codnotafiscal', codnotafiscal);

		modelo = modelo || <?php echo NotaFiscal::MODELO_NFE ?>;

		$('#modalDanfe').modal({show:true})
		$('#frameDanfe').attr("src", "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/danfe");
		$('#modalDanfe').css({'width': '80%', 'margin-left':'auto', 'margin-right':'auto', 'left':'10%'});
		$('#modalDanfe').off('hide');

		if (modelo == <?php echo NotaFiscal::MODELO_NFE ?>) {
			$('#btnImprimirNFCe').hide();
		}	else {
			$('#btnImprimirNFCe').show();
		}

		if (recarregar) {
			$('#modalDanfe').on('hide', function(){
				location.reload();
			});
		}
	}

	$('#modalProgressoNfe').modal('hide');
}

function NFePHPImprimir(codnotafiscal, impressora)
{
	if (impressora != null) {
		var data = { impressora: impressora };
	} else {
		var data = null;
	}
	$.ajax({
	  type: 'GET',
	  url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/imprimir",
	  headers: {"X-Requested-With":"XMLHttpRequest"},
		data: data
	}).done(function(resp) {
		if (resp.sucesso != true) {
			mensagem = "<h3 class='text-error'>" + resp.mensagem + "</h3>";
			bootbox.alert(mensagem);
		}
	}).fail(function( jqxhr, textStatus, error ) {
		NFePHPErro(jqxhr);
	});
	console.log(impressora);
}

function NFePHPMail(codnotafiscal, modelo, destinatario)
{

	if (destinatario != null) {
		var data = { destinatario: destinatario };
	} else {
		var data = null;
		// ABRE MODAL DE PROGRESSO
		$('#modalProgressoNfe').modal({show:true, keyboard:false})
	}

	// AJUSTA PERCENTUAL PROGRESSO
	$('#modalProgressoNfeLabelStatus').text('Enviando Email...');
	$('#modalProgressoNfeProgressBar').css('width', '75%');

	$.ajax({
	  type: 'GET',
	  url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/mail",
	  headers: {"X-Requested-With":"XMLHttpRequest"},
		data: data
	}).done(function(resp) {
		if (resp.sucesso == true && destinatario == null) {
			NFePHPDanfe(codnotafiscal, modelo, true);
			return;
		}
		$('#modalProgressoNfe').modal('hide');
		if (resp.sucesso) {
			var css = "text-success";
		} else {
			var css = "text-error"
		}
		mensagem = "<h3 class='" + css + "'>" + resp.mensagem + "</h3>";
		bootbox.alert(mensagem, function() {
			location.reload();
		});
	}).fail(function( jqxhr, textStatus, error ) {
		NFePHPErro(jqxhr);
	});
}

function NFePHPMailPerguntar (codnotafiscal, email)
{
	bootbox.prompt("Digite o endereço de e-mail:", "Cancelar", "OK", function(result) {
        if (result) {
            NFePHPMail (codnotafiscal, null, result);
        }
	}, email);

}

function NFePHPEnviarSincrono(codnotafiscal, modelo)
{
	// ABRE MODAL DE PROGRESSO
	$('#modalProgressoNfe').modal({show:true, keyboard:false})

	// AJUSTA PERCENTUAL PROGRESSO
	$('#modalProgressoNfeLabelStatus').text('Enviando NFe para Sefaz...');
	$('#modalProgressoNfeProgressBar').css('width', '50%');

	$.ajax({
	  type: 'GET',
	  url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/enviar-sincrono",
	  headers: {"X-Requested-With":"XMLHttpRequest"}
	}).done(function(resp) {
		if (resp.sucesso == true) {
			NFePHPMail(codnotafiscal, modelo);
			if (modelo == <?php echo NotaFiscal::MODELO_NFCE; ?>) {
				NFePHPImprimir(codnotafiscal, '<?php echo Yii::app()->user->getState('impressoraTermica') ?>');
			}
		} else {
			$('#modalProgressoNfe').modal('hide');
			mensagem = "<h3 class='text-error'>" + resp.cStat + " - " + resp.xMotivo + "</h3>";
			bootbox.alert(mensagem, function() {
				location.reload();
			});
		}
	}).fail(function( jqxhr, textStatus, error ) {
		NFePHPErro(jqxhr);
	});
}

function NFePHPCriar(codnotafiscal, modelo)
{
	// ABRE MODAL DE PROGRESSO
	$('#modalProgressoNfe').modal({show:true, keyboard:false})

	// AJUSTA PERCENTUAL PROGRESSO
	$('#modalProgressoNfeLabelStatus').text('Criando Arquivo XML...');
	$('#modalProgressoNfeProgressBar').css('width', '0%');

	$.ajax({
	  type: 'GET',
	  url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/criar",
	  headers: {"X-Requested-With":"XMLHttpRequest"}
	}).done(function(xml) {
		var tpEmis = $(xml).find('tpEmis').text();
		$('#modalProgressoNfeLabelStatus').text('Arquivo XML Criado...');
		$('#modalProgressoNfeProgressBar').css('width', '25%');
		// Se offline
		if (tpEmis == <?php echo NotaFiscal::TPEMIS_OFFLINE; ?>) {
			NFePHPDanfe(codnotafiscal, modelo, true);
			NFePHPImprimir(codnotafiscal, '<?php echo Yii::app()->user->getState('impressoraTermica') ?>');
		} else {
			NFePHPEnviarSincrono(codnotafiscal, modelo);
		}
	}).fail(function( jqxhr, textStatus, error ) {
		NFePHPErro(jqxhr);
	});
}

function NFePHPConsultar(codnotafiscal)
{
	$.ajax({
	  type: 'GET',
	  url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/consultar",
	  headers: {"X-Requested-With":"XMLHttpRequest"}
	}).done(function(resp) {
		if (resp.sucesso == true) {
			var css="text-success";
		} else {
			var css="text-error";
		}
		mensagem = "<h3 class='" + css + "'>" + resp.cStat + " - " + resp.xMotivo + "</h3>";
		bootbox.alert(mensagem, function() {
			location.reload();
		});
	}).fail(function( jqxhr, textStatus, error ) {
		NFePHPErro(jqxhr);
	});
}

function NFePHPCancelarInutilizar (codnotafiscal, tipo)
{
	bootbox.prompt("Digite a justificativa para " + tipo + " a NFe!", "Desistir", "OK", function(justificativa) {
		if (justificativa === null) {
			return;
		}
		$.ajax({
			type: 'GET',
			url: "<?php echo MGSPA_NFEPHP_URL; ?>" + codnotafiscal + "/" + tipo,
			headers: {"X-Requested-With":"XMLHttpRequest"},
			data: { justificativa: justificativa }
		}).done(function(resp) {
			if (resp.sucesso == true) {
				var css="text-success";
			} else {
				var css="text-error";
			}
			mensagem = "<h3 class='" + css + "'>" + resp.cStat + " - " + resp.xMotivo + "</h3>";
			bootbox.alert(mensagem, function() {
				location.reload();
			});
		}).fail(function( jqxhr, textStatus, error ) {
			NFePHPErro(jqxhr);
		});
	});
}

function NFePHPCancelar (codnotafiscal)
{
	NFePHPCancelarInutilizar(codnotafiscal, 'cancelar')
}

function NFePHPInutilizar (codnotafiscal)
{
	NFePHPCancelarInutilizar(codnotafiscal, 'inutilizar')
}


$(document).ready(function(){

	$('#frameDanfe').attr("src", "about:blank");

	// ENVIAR NFE
	$('.btnEnviarNfe').on('click', function (e) {
		e.preventDefault();
		NFePHPCriar($(this).data('codnotafiscal'), $(this).data('modelo'));
	});

	//CONSULTAR NFE
	$('.btnConsultarNfe').on('click', function (e) {
		e.preventDefault();
		NFePHPConsultar($(this).data('codnotafiscal'));
	});

	//CANCELAR NFE
	$('.btnCancelarNfe').on('click', function (e) {
		e.preventDefault();
		NFePHPCancelar($(this).data('codnotafiscal'));
	});

	//INUTILIZAR NFE
	$('.btnInutilizarNfe').on('click', function (e) {
		e.preventDefault();
		NFePHPInutilizar($(this).data('codnotafiscal'));
	});

	//enviar email
	$('.btnEnviarEmail').on('click', function (e) {
		e.preventDefault();
		NFePHPMailPerguntar($(this).data('codnotafiscal'), $(this).data('email'));
	});

	//abre janela vale
	$('.btnAbrirDanfe').click(function(e){
		e.preventDefault();
		NFePHPDanfe($(this).data('codnotafiscal'), $(this).data('modelo'), false);
	});

	//imprimir Danfe Matricial
	$('#btnImprimirNFCe').click(function(e){
		e.preventDefault();
		NFePHPImprimir($(this).data('codnotafiscal'), '<?php echo Yii::app()->user->getState('impressoraTermica') ?>');
	});

	$("*").bind('keydown.f9',function (e) {
		e.preventDefault();
		$(".btnEnviarNfe:first").trigger( "click" );
		return false;
	});


});
/*]]>*/
</script>
