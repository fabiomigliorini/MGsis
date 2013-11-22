<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario=>array('view','id'=>$model->codusuario),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem de Usuario', 'url'=>array('index')),
	array('label'=>'Novo Usuario', 'url'=>array('create')),
	array('label'=>'Detalhes do Usuario', 'url'=>array('view', 'id'=>$model->codusuario)),
	array('label'=>'Gerenciar Usuario', 'url'=>array('admin')),
);
?>

<h1>Alterar Usuario #<?php echo $model->codusuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>