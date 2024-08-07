<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Tipos de Produtos';
$this->breadcrumbs=array(
	'Tipos de Produtos'=>array('index'),
	$model->tipoproduto,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtipoproduto)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tipoProduto/delete', array('id' => $model->codtipoproduto))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->tipoproduto; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	//'codtipoproduto',
	array(
		'name'=>'codtipoproduto',
		'value'=>Yii::app()->format->formataCodigo($model->codtipoproduto),
		),
	'tipoproduto',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
