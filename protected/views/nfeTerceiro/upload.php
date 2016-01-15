<?php
$this->pagetitle = Yii::app()->name . ' - Carregar NFe de Terceiro Via Arquivo XML';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	'Carregar NFe de Terceiro Via Arquivo XML',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Carregar NFe de Terceiro Via Arquivo XML</h1>

<div class="row-fluid">
	<div class="row-fluid">
		<div class="span4">
			<?php 
			$form=$this->beginWidget('MGActiveForm',
				array(
					'id'=>'nfe-terceiro-form',
					'enableAjaxValidation' => false,
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)
			); 
			?>
			<?php 	

				if (empty($model->arquivoxml))
					$model->arquivoxml = '/media/publico/Arquivos/XML/Importar/';

				 echo $form->textField($model, 'arquivoxml', array('placeholder' => 'Chave', 'class'=>'input-xlarge'));
			?>
			<?php 
				$this->widget(
					'bootstrap.widgets.TbButton',
					array(
						'buttonType' => 'submit',
						'type' => 'primary',
						'label' => 'Procurar',
						'icon' => 'icon-ok',
						)
					); 
			?>
			<?php $this->endWidget(); ?>
		</div>
		<div class="span8" id="divResultadoProcura">
		</div>
	</div>
	<hr>
	<div class="row-fluid" id="divControleArquivos" hidden>
		<div class="span4">
			<div class="span4 btn-group" id="divBotoesArquivos" data-spy="affix">
				<button class="btn " id="btnTodos">Todos</button>
				<button class="btn " id="btnNenhum">Nenhum</button>
				<button class="btn btn-primary" id="btnImportar">Importar Selecionados</button>
			</div>
			
		</div>
		<div class="span8">
			<div class="row-fluid" id="divListagemArquivos">
			</div>
		</div>
	</div>
</div>


<script type='text/javascript'>


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

function formataMensagemImporta(data)
{
	var mensagem = '';
	
	if (data.codnfeterceiro != null)
	{
		url = '<?php echo Yii::app()->createUrl('nfeTerceiro/view', array('id'=>'codnfeterceiro'))?>';
		mensagem += '<a href="' + url.replace('codnfeterceiro', data.codnfeterceiro) + '" target="_blank">' ;
		mensagem += 'Abrir Nota';
		mensagem += '</a>' ;
	}

	if (data.xMotivo != null)
	{
		mensagem += '<h4>';

		if (data.cStat != null)
			mensagem += data.cStat + ' - ';

		mensagem += data.xMotivo + '</h4>';
	}
	
	if (data.ex != null)
		mensagem += '<pre>' + data.ex + '</pre>';
	
	if (!$.isEmptyObject(data.aResposta))
		mensagem += '<pre>' + JSON.stringify(data.aResposta, null, '\t') + '</pre>';

	return mensagem;
}

var arrArquivos = new Array();

function descobreArquivoID(arquivo)
{
	for	(i = 0; i < arrArquivos.length; i++) 
		if (arrArquivos[i] == arquivo)
			return i+1;
	
	return arrArquivos.push(arquivo)
}

function adicionaArquivoXml(arquivo)
{
	
	var arquivoID = descobreArquivoID(arquivo);
	
	if ($('#divArquivo' + arquivoID).length != 0)
		return;
	
	var diretorio = $("#NfeTerceiro_arquivoxml").val();
	var html = '<div id="divArquivo' + arquivoID + '" class="divArquivo alert row fluid">';
	html += '<div class="span7">';
	html += '<input type="checkbox" id="boxArquivo' + arquivoID + '" class="boxArquivo pull-left" data-arquivo="' + arquivo + '">';
	html += '<label for="boxArquivo' + arquivoID + '">';
	html += '&nbsp';
	html += arquivoID;
	html += '&nbsp-&nbsp';
	html += arquivo.replace(diretorio, '');
	html += '</label>';
	html += '</div>';
	html += '<div id="divArquivoResultado' + arquivoID + '" class="divArquivoResultado span5">';
	html += '</div>';
	html += '</div>';
	$('#divListagemArquivos').append(html);
}

function habilitaBtnImportar()
{
	if ($('.boxArquivo:checked').length > 0)
		$('#btnImportar').removeAttr("disabled");
	else
		$('#btnImportar').attr("disabled", true);
}

function procuraXml(diretorio)
{
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/procuraXml')?>", { diretorio: diretorio })
		.done(function(data) {			
			var mensagem = formataMensagem(data);
			if (data.retorno)
			{
				$('#divListagemArquivos').html('');
				$('#divControleArquivos').show();
				jQuery.each(data.aResposta, function(numero, arquivo) {
					adicionaArquivoXml(arquivo);
				});
			}
			$('#divResultadoProcura').html(mensagem);
			$('.boxArquivo').change(function () {
				habilitaBtnImportar();
			});
			habilitaBtnImportar();
		})
		.fail(function( jqxhr, textStatus, error ) {
			bootbox.alert(error);
		});
}

function importaArquivoXml(arquivo)
{
	var arquivoID = descobreArquivoID(arquivo);
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/importaArquivoXml')?>", { arquivo: arquivo })
		.done(function(data) {			
			//var mensagem = formataMensagem(data);
			if (data.retorno)
			{
				$('#boxArquivo' + arquivoID).attr("disabled", true);
				$('#boxArquivo' + arquivoID).prop("checked", false);
				$('#divArquivo' + arquivoID).addClass('alert-success');
				$('#divArquivo' + arquivoID).removeClass('alert-error');
			}
			else
			{
				$('#divArquivo' + arquivoID).removeClass('alert-success');
				$('#divArquivo' + arquivoID).addClass('alert-error');
			}
			$('#divArquivoResultado' + arquivoID).html(formataMensagemImporta(data));
		})
		.fail(function( jqxhr, textStatus, error ) {
			$('#divArquivo' + arquivoID).addClass('alert-error');
			$('#divArquivoResultado' + arquivoID).html(error);
			$('#divArquivoResultado' + arquivoID).show();
		});
}
	
$(document).ready(function() {
	
	 procuraXml($("#NfeTerceiro_arquivoxml").val());

	//$("#Pessoa_fantasia").Setcase();

	$('#nfe-terceiro-form').submit(function(e) {
        var currentForm = this;
        e.preventDefault();
		procuraXml($("#NfeTerceiro_arquivoxml").val());
    });
	
	$('#btnImportar').click(function(e) {
		$('.boxArquivo:checked').each(function(){
			 importaArquivoXml($(this).data('arquivo'));
		});
    });
	
	$('#btnTodos').click(function(e) {
		$('.boxArquivo').prop("checked", true);
		habilitaBtnImportar();
    });
	
	$('#btnNenhum').click(function(e) {
		$('.boxArquivo').prop("checked", false);
		habilitaBtnImportar();
    });
	
});

</script>