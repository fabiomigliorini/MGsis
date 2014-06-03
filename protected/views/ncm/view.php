<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes NCM';
$this->breadcrumbs=array(
	'NCM'=>array('index'),
	$model->ncm,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codncm)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('ncm/delete', array('id' => $model->codncm))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->ncm; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	//'codncm',
	array(
		'name'=>'codncm',
		'value'=>Yii::app()->format->formataCodigo($model->codncm),
		),
	'ncm',
	//'descricao',
	array(
		'name'=>'descricao',
		'value'=>nl2br(CHtml::encode($model->descricao)),
		'type'=>'raw',
		),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
