<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes CFOP';
$this->breadcrumbs=array(
	'CFOP'=>array('index'),
	$model->codcfop,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcfop)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('cfop/delete', array('id' => $model->codcfop))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codcfop; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	'codcfop',
	//'cfop',
	array(
		'name'=>'cfop',
		'value'=>nl2br(CHtml::encode($model->cfop)),
		'type'=>'raw',
		),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
