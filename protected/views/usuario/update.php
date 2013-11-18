<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuarios'=>array('index'),
	$model->codusuario=>array('view','id'=>$model->codusuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List Usuario', 'url'=>array('index')),
	array('label'=>'Create Usuario', 'url'=>array('create')),
	array('label'=>'View Usuario', 'url'=>array('view', 'id'=>$model->codusuario)),
	array('label'=>'Manage Usuario', 'url'=>array('admin')),
);
?>

<h1>Update Usuario <?php echo $model->codusuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>