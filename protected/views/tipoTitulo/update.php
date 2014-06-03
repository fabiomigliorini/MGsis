<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tipo Título';
$this->breadcrumbs=array(
	'Tipos de Títulos'=>array('index'),
	$model->tipotitulo=>array('view','id'=>$model->codtipotitulo),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtipotitulo)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Tipo Título <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtipotitulo)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>