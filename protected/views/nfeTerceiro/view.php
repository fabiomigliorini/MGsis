<?php

/**
 * @var NfeTerceiro $model
 */


$this->pagetitle = Yii::app()->name . ' - Detalhes da NFe de Terceiro';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	$model->nfechave,
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Download Nfe', 'icon'=>'icon-download-alt', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnDownloadNfe'), 'visible'=>empty($model->codnotafiscal) ),
	array('label'=>'Informar Detalhes', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnfeterceiro), 'visible'=>$model->podeEditar()),
	array('label'=>'Importar', 'icon'=>'icon-thumbs-up', 'url'=>'#', 'visible'=>$model->podeEditar(), 'linkOptions'=>	array('id'=>'btnImportar')), 
	//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">

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


function enviarEventoManifestacao(indManifestacao, justificativa)
{
	
	$.getJSON("<?php echo Yii::app()->createUrl('NFePHPNovo/manifesta')?>", { 
		codnfeterceiro: <?php echo $model->codnfeterceiro; ?>,
		indmanifestacao: indManifestacao, 
		justificativa: justificativa 
	})
		.done(function(data) {
			var mensagem = formataMensagem(data);
			bootbox.alert(mensagem, function() {
				location.reload();
			});
		})
		.fail(function( jqxhr, textStatus, error ) {
			bootbox.alert(error, function() {
				location.reload();
			});
		});
	
}

function downloadNfe ()
{
	$.getJSON("<?php echo Yii::app()->createUrl('nfeTerceiro/downloadNfe')?>", { id: <?php echo $model->codnfeterceiro; ?> } )
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

/*<![CDATA[*/
$(document).ready(function(){

	$('#btnManifestacaoCiencia').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz a <b class='lead text-warning'>Ciência da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_CIENCIA; ?>, null);
		});
	});
	
	$('#btnManifestacaoRealizada').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz a <b class='lead text-success'>Confirmação da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_REALIZADA; ?>, null);
		});
	});
	
	$('#btnManifestacaoDesconhecida').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Desconhecimento da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA; ?>, null);
		});
	});
	
	$('#btnManifestacaoNaoRealizada').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Operação não Realizada</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
			{
				bootbox.prompt("Digite a justificativa:", "Cancelar", "OK", function(result) 
				{ 
					if (result === null)
						return;
					enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA; ?>, result);
				});
				//console.log('btnManifestacaoNaoRealizada');
			}
		});
	});
	
	jQuery('body').on('click','#btnExcluir',function(e) {
		e.preventDefault();
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfeTerceiro/delete', array('id' => $model->codnfeterceiro))?>",{});
		});
	});
	
	jQuery('body').on('click','#btnImportar',function(e) {
		e.preventDefault();
		bootbox.confirm("Importar essa NFe de Terceiro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nfeTerceiro/importar',array('id'=>$model->codnfeterceiro))?>",{});
		});
	});
	
	jQuery('body').on('click','#btnDownloadNfe',function(e) {
		e.preventDefault();
		bootbox.confirm("Efetuar o Download da NFe?", function(result) {
			if (result)
				downloadNfe();
		});
	});
});
/*]]>*/
</script>

<?php 
	$manifestacao = $model->getIndManifestacaoDescricao();
	$cssmanif = '';
	switch ($model->indmanifestacao)
	{
		case NfeTerceiro::INDMANIFESTACAO_CIENCIA:
			$cssmanif = 'btn-warning';
			break;
		case NfeTerceiro::INDMANIFESTACAO_REALIZADA:
			$cssmanif = 'btn-success';
			break;
		case NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA:
		case NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA:
			$cssmanif = 'btn-danger';
			break;
	}
	
?>

<h1>
	<?php echo Yii::app()->format->formataChaveNfe($model->nfechave); ?>
	<div class="btn-group">
		<a class="btn dropdown-toggle <?php echo $cssmanif; ?>" data-toggle="dropdown" href="#">
			<?php echo $manifestacao; ?>
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<?php if($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_CIENCIA): ?>
				<li>
					<a href='#' class='' id="btnManifestacaoCiencia">
						<span class='badge badge-warning'>&nbsp;</span>
						Ciência da Operação
					</a>	
				</li>
			<?php endif; ?>
			<?php if($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_REALIZADA): ?>
				<li>
					<a href='#' class='' id="btnManifestacaoRealizada">
						<span class='badge badge-success'>&nbsp;</span>
						Operação Realizada
					</a>	
				</li>
			<?php endif; ?>
			<li class="dropdown-submenu">
				<a tabindex="-1" href="#" class=''>
					<span class='badge badge-important'>&nbsp;</span>
					Negar Operação					
				</a>
				<ul class="dropdown-menu">
					<?php if($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_DESCONHECIDA): ?>
						<li>
							<a class='' href='#' id="btnManifestacaoDesconhecida">
								<span class='badge badge-important'>&nbsp;</span>
								Desconhecida
							</a>
						</li>
					<?php endif; ?>
					<?php if($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_NAOREALIZADA): ?>
						<li>
							<a class='' href='#' id="btnManifestacaoNaoRealizada">
								<span class='badge badge-important'>&nbsp;</span>
								Não Realizada
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</li>	
		</ul>
	</div>
	
</h1>

<div class="row-fluid">
	<div class="span3">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'serie',
				'numero',
			),
		)); 

		?>
	</div>
	<div class="span6">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'codfilial',
					'value'=>isset($model->Filial)?CHtml::link(CHtml::encode($model->Filial->filial), array("filial/view", "id"=>$model->codfilial)):null,
					'type'=>"raw",
				),
				array(
					'name'=>'codpessoa',
					'value'=>isset($model->Pessoa)?CHtml::link(CHtml::encode($model->Pessoa->fantasia), array("pessoa/view", "id"=>$model->codpessoa)):null,
					'type'=>"raw",
				),
			),
		)); 

		?>		
	</div>
	<div class="span3">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'emissao',
				array(
					'name'=>'valortotal',
					'value'=>Yii::app()->format->formatNumber($model->valortotal),
				),
			),
		)); 

		?>		
	</div>
</div>


<?php if (!empty($model->NfeTerceiroItems)): ?>
<h3>Itens</h3>
<div id="ListagemItens">
	<?php 
	$this->renderPartial("_view_itens", array("model"=>$model))
	?>
</div>
<br>
<?php endif; ?>
<h3>Detalhes</h3>

<small class="row-fluid">
	<div class="span4">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name' => 'codnfeterceiro',
					'value' => Yii::app()->format->formataCodigo($model->codnfeterceiro),
				),
				array(
					'name'=>'codnaturezaoperacao',
					'value'=>isset($model->NaturezaOperacao)?CHtml::encode($model->NaturezaOperacao->naturezaoperacao):null,
					'type'=>"raw",
				),
				array (
					'name'=>'codnotafiscal',
					'value'=>isset($model->NotaFiscal)?CHtml::link(CHtml::encode(Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)), array("notaFiscal/view", "id"=>$model->codnotafiscal)):null,
					'type'=>"raw",

				),
				'entrada',
			),
		)); 

		?>
	</div>
	<div class="span5">
		<?php 
		
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'emitente',
				array(
					'name' => 'cnpj',
					'value' => Yii::app()->format->formataCnpjCpf($model->cnpj, false)
				),
				'ie',
				'nfedataautorizacao',
				'nsu',
				array(
					'name' => 'indsituacao',
					'value' => $model->getIndSituacaoDescricao(),
				),
				array(
					'name' => 'indmanifestacao',
					'value' => $manifestacao,
				),
				array(
					'name' => 'justificativa',
					'value' => nl2br(CHtml::encode($model->justificativa)),
					'type' => 'raw',
				),

			),
		)); 

		?>
	</div>
	<div class="span3 pull-right">
		<?php 
		$this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array(
						'name' => 'valorprodutos',
						'value' => Yii::app()->format->formatNumber($model->valorprodutos),
				),
				array(
						'name' => 'valorfrete',
						'value' => Yii::app()->format->formatNumber($model->valorfrete),
				),
				array(
						'name' => 'valorseguro',
						'value' => Yii::app()->format->formatNumber($model->valorseguro),
				),
				array(
						'name' => 'valordesconto',
						'value' => Yii::app()->format->formatNumber($model->valordesconto),
				),
				array(
						'name' => 'valoroutras',
						'value' => Yii::app()->format->formatNumber($model->valoroutras),
				),
				array(
						'name' => 'icmsbase',
						'value' => Yii::app()->format->formatNumber($model->icmsbase),
				),
				array(
						'name' => 'icmsvalor',
						'value' => Yii::app()->format->formatNumber($model->icmsvalor),
				),
				array(
						'name' => 'icmsstbase',
						'value' => Yii::app()->format->formatNumber($model->icmsstbase),
				),
				array(
						'name' => 'icmsstvalor',
						'value' => Yii::app()->format->formatNumber($model->icmsstvalor),
				),
				array(
						'name' => 'ipivalor',
						'value' => Yii::app()->format->formatNumber($model->ipivalor),
				),
				array(
					'name'=>'valortotal',
					'value'=>Yii::app()->format->formatNumber($model->valortotal),
				),
			),
		)); 

		?>		
	</div>
	
	
</small>

<?php if (!empty($model->NfeTerceiroDuplicatas)): ?>
<h3>Duplicatas</h3>
<div id="ListagemDuplicatas">
	<?php 
	$this->renderPartial("_view_duplicatas", array("model"=>$model))
	?>
</div>
<br>
<?php endif; ?>

<?php

$this->widget('UsuarioCriacao', array('model'=>$model));

?>
