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

function enviarEventoManifestacao (indManifestacao, justificativa)
{
	$.getJSON("<?php echo Yii::app()->createUrl('nfeTerceiro/enviarEventoManifestacao')?>", { 
		id: <?php echo $model->codnfeterceiro; ?>,
		indManifestacao: indManifestacao,
		justificativa: justificativa
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
	
	$('#btnManifestacaoConfirmada').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz a <b class='lead text-success'>Confirmação da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				enviarEventoManifestacao (<?php echo NfeTerceiro::INDMANIFESTACAO_CONFIRMADA; ?>, null);
		});
	});
	
	$('#btnManifestacaoDesconhecida').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Desconhecimento da Operação</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				console.log('btnManifestacaoDesconhecida');
		});
	});
	
	$('#btnManifestacaoNaoRealizada').click(function(e) {
		e.preventDefault();
		bootbox.confirm("Enviar à Sefaz o comunidado de <b class='lead text-error'>Operação não Realizada</b>?<br><br>Tenha cuidado ao confirmar, pois esta ação <b>não poderá ser desfeita</b>!", function(result) {
			if (result)
				console.log('btnManifestacaoNaoRealizada');
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

<h1><?php echo Yii::app()->format->formataChaveNfe($model->nfechave); ?></h1>

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

<h3>Detalhes
<?php 
	/*
	if ($model->indmanifestacao != NfeTerceiro::INDMANIFESTACAO_SEM)
	{*/
		?>
			<button class="btn btn-warning" id="btnManifestacaoCiencia">
				<i class="icon-pause icon-white"></i> 
				Ciência da Operação
			</button>
			<button class="btn btn-success" id="btnManifestacaoConfirmada">
				<i class="icon-thumbs-up icon-white"></i> 
				Operação Realizada
			</button>
			<div class="btn-group">
				<a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="icon-thumbs-down icon-white"></i>
					Negar Operação
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="#" id="btnManifestacaoDesconhecida">Desconhecida</a></li>
					<li><a href="#" id="btnManifestacaoNaoRealizada">Não Realizada</a></li>
				</ul>
			</div>
		<?php
	//}
	?>	
</h3>

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
						'value' => $model->getIndManifestacaoDescricao(),
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
