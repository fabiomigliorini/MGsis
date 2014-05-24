<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Nota Fiscal Produto Barra'=>array('index'),
	$model->codnotafiscalprodutobarra,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscalprodutobarra)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nota-fiscal-produto-barra/delete', array('id' => $model->codnotafiscalprodutobarra))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codnotafiscalprodutobarra; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codnotafiscalprodutobarra',
		'codnotafiscal',
		'codprodutobarra',
		'codcfop',
		'descricaoalternativa',
		'quantidade',
		'valorunitario',
		'valortotal',
		'icmsbase',
		'icmspercentual',
		'icmsvalor',
		'ipibase',
		'ipipercentual',
		'ipivalor',
		'icmsstbase',
		'icmsstpercentual',
		'icmsstvalor',
		'csosn',
		'codnegocioprodutobarra',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
