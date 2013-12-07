<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Usuario';
$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario=>array('view','id'=>$model->codusuario),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codusuario)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Usuario #<?php echo $model->codusuario; ?></h1>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>