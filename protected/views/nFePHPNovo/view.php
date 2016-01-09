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
$(document).ready(function(){

	atualizaListagemNotas();
		
	jQuery('body').on('click','#btnAtualizaListagemNotas',function() {
		atualizaListagemNotas();
	});
	
	jQuery('body').on('click','#btnLimpaListagemNotasAutorizadas',function() {
		limpaListagemNotasAutorizadas();
	});
	
	jQuery('body').on('click','#btnParar',function() {
		if (!$('#btnParar').hasClass('disabled'))
			$('#btnParar').button('loading');
	});


	function imprimirNFCe (codnotafiscal)
	{

		var modelo = $('#Nota' + codnotafiscal).data('modelo');
		var tpEmis = $('#Nota' + codnotafiscal).data('tpemis');
		
		if ((modelo != <?php echo NotaFiscal::MODELO_NFCE; ?>) || (tpEmis == <?php echo NotaFiscal::TPEMIS_OFFLINE; ?>))
		{
			$('#Nota' + codnotafiscal).removeClass('alert-info');
			$('#Nota' + codnotafiscal).addClass('alert-success');
			percorreNotas(codnotafiscal);
			return;
		}

		$('#divResultado').append('<h3>Imprimindo NFCe<h3>');
		
		$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/imprimirNFCe')?>", { codnotafiscal: codnotafiscal })
			.done(function(data) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-success');
				percorreNotas(codnotafiscal);
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-success');
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
							$('#Nota' + codnotafiscal).removeClass('alert-info');
							$('#Nota' + codnotafiscal).addClass('alert-success');
							percorreNotas(codnotafiscal);
						}
					}
				}
				else
				{
					$('#Nota' + codnotafiscal).removeClass('alert-info');
					$('#Nota' + codnotafiscal).addClass('alert-error');
					percorreNotas(codnotafiscal);
				}
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-error');
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
					$('#Nota' + codnotafiscal).removeClass('alert-info');
					$('#Nota' + codnotafiscal).addClass('alert-error');
					percorreNotas(codnotafiscal);
				}
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-error');
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
					$('#Nota' + codnotafiscal).removeClass('alert-info');
					$('#Nota' + codnotafiscal).addClass('alert-error');
					percorreNotas(codnotafiscal);
				}
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-error');
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
					$('#Nota' + codnotafiscal).removeClass('alert-info');
					$('#Nota' + codnotafiscal).addClass('alert-error');
					percorreNotas(codnotafiscal);
				}
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#Nota' + codnotafiscal).removeClass('alert-info');
				$('#Nota' + codnotafiscal).addClass('alert-error');
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
			$('#btnParar').button('reset');
			return;
		}
		
		var codnotafiscal = $('.notapendente').not('.alert-success').not('.alert-error').data('codnotafiscal');
		
		if (typeof codnotafiscal === "undefined")
		{
			setTimeout(function(){ 
				atualizaListagemNotas();
			}, 3000); // 3 segundos
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
						'	<div class="accordion-heading">' +
						'		<a class="accordion-toggle" data-toggle="collapse" data-parent="#divListagemNotas" href="#collapse' + codnotafiscal + '">' +
						'			<div class="badge">' + dados.tpEmis + '</div>' +
						'			' + dados.filial +
						'			<div class="pull-right"><div class="badge"> ' + dados.modelo + '</div>' +
						'					'+ dados.numero + 
						'			</div>'+
						'		</a>' +
						'	</div>' +
						'	<div id="collapse' + codnotafiscal + '" class="accordion-body collapse">' +
						'		<div class="accordion-inner">' +
						'			<a href="<?php echo Yii::app()->createUrl('notaFiscal/view')?>&id=' + codnotafiscal + '">' +
						'					'+ dados.numero + 
						'			</a>'+
						'			<div id="divResultado' + codnotafiscal + '">' +
						'			</div>' +
						'		</div>' +
						'	</div>' +
						'</div>';

			/*
			var html  = '<div class="alert notapendente" id="Nota' + codnotafiscal + '" data-codnotafiscal="' + codnotafiscal + '" data-modelo="' + dados.modelo + '">';
			html     += dados.filial;
			html     += ' ';
			html     += '<div class="badge pull-right">' + dados.modelo + '</div>';
			html     += ' ';
			html     += '<div class="pull-right">' + dados.numero + '</div>';
			html     += '</div>';
			*/
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
		limpaListagemNotasAutorizadas();
		$('#btnParar').button('reset');
		
		$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/listagemNotasPendentes')?>")
			.done(function(data) {
				jQuery.each(data, function(codnotafiscal, dados) {
					adicionaNota(codnotafiscal, dados);
				});
				percorreNotas(0);
			})
			.fail(function( jqxhr, textStatus, error ) {
				$('#modalProgressoNfe').modal('hide');
				bootbox.alert(error, function() {
					location.reload();
				});
			});
		
	}
});
/*]]>*/
</script>

<div class="affix affix-top">
	<input type="button" class="btn" id="btnAtualizaListagemNotas" value="Atualizar Listagem">
	<input type="button" class="btn" id="btnLimpaListagemNotasAutorizadas" value="Limpar Notas Autorizadas">
	<button type="button" class="btn primary disabled" id="btnParar" data-loading-text="Parando...">Parar Processos</button>
</div>
<br>
<br>
<br>
<div class="row-fluid">
	<div class="span6">
		<div class="accordion" id="divListagemNotas">
		</div>
	</div>
	<div class="span6 alert" id="divResultado">
		
	</div>
</div>
