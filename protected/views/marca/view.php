<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Marca';
$this->breadcrumbs=array(
	'Marca'=>array('index'),
	$model->marca,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codmarca)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('marca/delete', array('id' => $model->codmarca))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->marca; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codmarca',
		'site',
		'descricaosite',
		),
	)); 

$arq = Yii::app()->basePath . "/../images/marca/" . $model->codmarca . ".jpg";
if (file_exists($arq))
	echo CHtml::image( Yii::app()->baseUrl . "/images/marca/" . $model->codmarca . ".jpg"); 
?>
<br>
<?php

$this->widget('UsuarioCriacao', array('model'=>$model));

?>
