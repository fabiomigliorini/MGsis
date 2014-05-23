<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Natureza da Operação';
$this->breadcrumbs=array(
	'Natureza da Operação'=>array('index'),
	$model->naturezaoperacao,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnaturezaoperacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('naturezaOperacao/delete', array('id' => $model->codnaturezaoperacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->naturezaoperacao; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codnaturezaoperacao',
		'naturezaoperacao',
		'codoperacao',
		'emitida',
		'observacoesnf',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
