<?php
$this->pagetitle = Yii::app()->name . ' - NFePHP';
$this->breadcrumbs=array(
	'NFePHP',
);

$this->menu=array(
//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
//array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codmarca)),
//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/

function imprimirNFCe (codnotafiscal)
{

	var modelo = $('#Nota' + codnotafiscal).data('modelo');
	var tpEmis = $('#Nota' + codnotafiscal).data('tpemis');

	if ((modelo != <?php echo NotaFiscal::MODELO_NFCE; ?>) || (tpEmis == <?php echo NotaFiscal::TPEMIS_OFFLINE; ?>))
	{
		registraNotaSucesso(codnotafiscal);
		percorreNotas(codnotafiscal);
		return;
	}

	$('#divResultado').append('<h3>Imprimindo NFCe<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/imprimirNFCe')?>", { codnotafiscal: codnotafiscal, impressoraUsuarioCriacao: 1 })
		.done(function(data) {
			registraNotaSucesso(codnotafiscal);
			percorreNotas(codnotafiscal);
		})
		.fail(function( jqxhr, textStatus, error ) {
			registraNotaSucesso(codnotafiscal);
			percorreNotas(codnotafiscal);
		});

}

function enviarEmail(codnotafiscal)
{

	$('#divResultado').append('<h3>Enviando Email<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/enviarEmail')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			imprimirNFCe(codnotafiscal);
		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#divResultado').append('<pre>' + error + '</pre>');
			imprimirNFCe(codnotafiscal);
		});

}


function consultarNfe (codnotafiscal)
{
	$('#divResultado').append('<h3>Consulta NFe<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/consultar')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			if (data.retorno)
			{
				if (data.cStat == 217) // NAO CONSTA NA SEFAZ
				{
					criaXml(codnotafiscal);
				}
				else
				{
					if (data.cStat == 100) // Autorizada
					{
						enviarEmail(codnotafiscal);
					}
					else
					{
						registraNotaSucesso(codnotafiscal);
						percorreNotas(codnotafiscal);
					}
				}
			}
			else
			{
				registraNotaErro(codnotafiscal);
				percorreNotas(codnotafiscal);
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			registraNotaErro(codnotafiscal);
			$('#divResultado').append('<pre>' + error + '</pre>');
			percorreNotas(codnotafiscal);
		});
}

function criaXml(codnotafiscal)
{
	$('#divResultado').append('<h3>Criando XML<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/criaXml')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			if (data.retorno)
			{
				enviarNfe(codnotafiscal);
			}
			else
			{
				registraNotaErro(codnotafiscal);
				percorreNotas(codnotafiscal);
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			registraNotaErro(codnotafiscal);
			$('#divResultado').append('<pre>' + error + '</pre>');
			percorreNotas(codnotafiscal);
		});

}

function enviarNfe(codnotafiscal)
{
	$('#divResultado').append('<h3>Enviando NFe para Sefaz<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/enviar')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			if (data.retorno)
			{
				setTimeout(function(){ 
					consultarProtocoloNfe(codnotafiscal);
				}, 3000); // 3 segundos
			}
			else
			{
				registraNotaErro(codnotafiscal);
				percorreNotas(codnotafiscal);
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			registraNotaErro(codnotafiscal);
			$('#divResultado').append('<pre>' + error + '</pre>');
			percorreNotas(codnotafiscal);
		});

}

function consultarProtocoloNfe(codnotafiscal)
{
	$('#divResultado').append('<h3>Consultando Protocolo<h3>');

	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/consultarProtocolo')?>", { codnotafiscal: codnotafiscal } )
		.done(function(data) {
			$('#divResultado').append('<pre>' + JSON.stringify(data, null, '\t') + '</pre>');
			if (data.cStat == 100) // Autorizada
			{
				enviarEmail(codnotafiscal);
			}
			else
			{
				registraNotaErro(codnotafiscal);
				percorreNotas(codnotafiscal);
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			registraNotaErro(codnotafiscal);
			$('#divResultado').append('<pre>' + error + '</pre>');
			percorreNotas(codnotafiscal);
		});

}

function percorreNotas(codnotafiscalUltima)
{

	$('#divResultado' + codnotafiscalUltima).html($('#divResultado').html());
	$('#divResultado').html('');

	if ($('#btnParar').hasClass('disabled'))
	{
		$('#btnIniciar').button('reset');
		$('#btnParar').data('loading-text', 'Parado');
		$('#btnParar').button('reset');
		$('#btnParar').button('loading');
		return;
	}

	var codnotafiscal = $('.notapendente').not('.alert-success').not('.alert-error').data('codnotafiscal');

	if (typeof codnotafiscal === "undefined")
	{
		setTimeout(function(){ 
			atualizaListagemNotas();
		}, 10000); // 10 segundos
	}
	else
	{
		$('#Nota' + codnotafiscal).addClass('alert-info');
		consultarNfe(codnotafiscal);
	}
}

function limpaListagemNotasAutorizadas()
{
	$('.notapendente.alert-success').each(function(i) {
		$(this).remove();
	});
}

function adicionaNota(codnotafiscal, dados)
{
	if ($('#Nota' + codnotafiscal).length == 0)
	{

		var html  = '<div class="accordion-group notapendente"  id="Nota' + codnotafiscal + '" data-codnotafiscal="' + codnotafiscal + '" data-tpemis="' + dados.tpEmis + '" data-modelo="' + dados.modelo + '">' +
					'	<div class="accordion-heading row-fluid">' +
					'		<a class="accordion-toggle" data-toggle="collapse" data-parent="#divListagemNotas" href="#collapse' + codnotafiscal + '">' +
					'			<div class="span2">' + dados.filial + '</div>'+
					'			<div class="span1 text-center">' + dados.modelo + '&nbsp&nbsp&nbsp&nbsp' + dados.tpEmis +'</div>' +
					'			<div class="span1 text-right">' + dados.numero + '</div>' +
					'			<div class="span3 text-center">' + dados.emissao + '</div>' +
					'			<div class="span3 text-center">' + dados.nfedataenvio + '</div>' +
					'			<div class="span2 text-center">' + dados.usuario + '</div>' +
					'		</a>' +
					'	</div>' +
					'	<div id="collapse' + codnotafiscal + '" class="accordion-body collapse">' +
					'		<div class="accordion-inner">' +
					'			<a href="<?php echo Yii::app()->createUrl('notaFiscal/view')?>&id=' + codnotafiscal + '" target="_blank">' +
					'					Abrir nota fiscal '+ dados.numero + 
					'			</a>'+
					'			<div id="divResultado' + codnotafiscal + '">' +
					'			</div>' +
					'		</div>' +
					'	</div>' +
					'</div>';

		$('#divListagemNotas').append(html);
	}
	else
	{
		$('#Nota' + codnotafiscal).removeClass('alert-success');
		$('#Nota' + codnotafiscal).removeClass('alert-error');
	}
}

function atualizaListagemNotas ()
{
	$('#btnIniciar').button('loading');
	$('#btnParar').data('loading-text', 'Parando...');
	$('#btnParar').button('reset');


	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/listagemNotasPendentes')?>")
		.done(function(data) {
			var total = 0;
			jQuery.each(data, function(codnotafiscal, dados) {
				total++;
				adicionaNota(codnotafiscal, dados);
			});
			$('#divTotalSucesso').text(0);
			$('#divTotalErro').text(0);
			$('#divTotal').text(total);
			calculaProgresso();
			percorreNotas(0);
		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#modalProgressoNfe').modal('hide');
			bootbox.alert(error, function() {
				location.reload();
			});
		});

}

function registraNotaSucesso(codnotafiscal)
{
	var iTotal = parseInt($('#divTotalSucesso').text());
	iTotal++;
	$('#divTotalSucesso').text(iTotal);
	$('#Nota' + codnotafiscal).removeClass('alert-info');
	$('#Nota' + codnotafiscal).addClass('alert-success');
	calculaProgresso();
}

function registraNotaErro(codnotafiscal)
{
	var iTotal = parseInt($('#divTotalErro').text());
	iTotal++;
	$('#divTotalErro').text(iTotal);
	$('#Nota' + codnotafiscal).removeClass('alert-info');
	$('#Nota' + codnotafiscal).addClass('alert-error');
	calculaProgresso();
}

function calculaProgresso()
{
	var iSucesso = parseInt($('#divTotalSucesso').text());
	var iErro = parseInt($('#divTotalErro').text());
	var iTotal = parseInt($('#divTotal').text());
	var iPerc = 0;
	if (iTotal>0)
		iPerc = parseInt(((iSucesso + iErro) / iTotal)*100);
	$('#divProgresso').css('width', iPerc + '%');
}

$(document).ready(function(){

	atualizaListagemNotas();
		
	jQuery('body').on('click','#btnIniciar',function() {
		if (!$('#btnIniciar').hasClass('disabled'))
			atualizaListagemNotas();
	});
	
	jQuery('body').on('click','#btnLimpar',function() {
		limpaListagemNotasAutorizadas();
	});
	
	jQuery('body').on('click','#btnParar',function() {
		if (!$('#btnParar').hasClass('disabled'))
			$('#btnParar').button('loading');
	});
	
});
/*]]>*/
</script>

<!--
<div class="affix affix-top">
	<div class="span5 row-fluid">
	</div>
</div>
-->
<div class="row-fluid">
	<div class="span4">
		<div class="btn-group span12">
			<button type="button" class="btn span3 btn-success" id="btnIniciar" data-loading-text="Executando...">Iniciar</button>
			<button type="button" class="btn span3 btn-danger" id="btnParar" data-loading-text="Parando...">Parar</button>
			<button type="button" class="btn span6" id="btnLimpar">Limpar Autorizadas</button>
		</div>
	</div>
	<div class="span8">
		<div class="span2">
			<span id="divTotalSucesso" class="badge badge-success">?</span>
			<span id="divTotalErro" class="badge badge-important">?</span>
			<span id="divTotal" class="badge badge-inverse">?</span>
		</div>
		<div class="span10">
			<div class="progress progress-striped active">
				<div class="bar" id="divProgresso" style="width: 0%;"></div>
			</div>
		</div>
	</div>
</div>
<hr>

<div class="row-fluid">
	<div class="span6">
		<div class="row-fluid">
			<b class="span2">Filial</b>
			<b class="span1 text-center">Modelo</b>
			<b class="span1 text-right">Número</b>
			<b class="span3 text-center">Emissão</b>
			<b class="span3 text-center">Envio</b>
			<b class="span2 text-center">Usuário</b>
		</div>
		<div class="accordion" id="divListagemNotas">
		</div>
	</div>
	<div class="span6" id="divResultado">
	</div>
</div>
