<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Notas Fiscais';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	$model->codnotafiscal,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscal)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nota-fiscal/delete', array('id' => $model->codnotafiscal))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codnotafiscal; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codnotafiscal',
		'codnaturezaoperacao',
		'emitida',
		'nfechave',
		'nfeimpressa',
		'serie',
		'numero',
		'emissao',
		'saida',
		'codfilial',
		'codpessoa',
		'observacoes',
		'volumes',
		'fretepagar',
		'codoperacao',
		'nfereciboenvio',
		'nfedataenvio',
		'nfeautorizacao',
		'nfedataautorizacao',
		'valorfrete',
		'valorseguro',
		'valordesconto',
		'valoroutras',
		'nfecancelamento',
		'nfedatacancelamento',
		'nfeinutilizacao',
		'nfedatainutilizacao',
		'justificativa',
		'valorprodutos',
		'valortotal',
		'icmsbase',
		'icmsvalor',
		'icmsstbase',
		'icmsstvalor',
		'ipibase',
		'ipivalor',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
