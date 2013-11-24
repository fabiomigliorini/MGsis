<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
$this->pagetitle = Yii::app()->name . ' - Alterar Usuario #' . $model->codusuario;

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario=>array('view','id'=>$model->codusuario),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Detalhes', 'url'=>array('view', 'id'=>$model->codusuario)),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Alterar Usuario #<?php echo $model->codusuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>