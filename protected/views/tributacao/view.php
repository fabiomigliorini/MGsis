<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Tributação';
$this->breadcrumbs=array(
	'Tributações'=>array('index'),
	$model->tributacao,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtributacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tributacao/delete', array('id' => $model->codtributacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->tributacao; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'codtributacao',
			'value'=>Yii::app()->format->formataCodigo($model->codtributacao),
			),
		'tributacao',
		'aliquotaicmsecf',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
