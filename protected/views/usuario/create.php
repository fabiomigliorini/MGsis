<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	'Novo',
);

$this->menu=array(
	array('label'=>'Listagem de Usuario', 'url'=>array('index')),
	array('label'=>'Gerenciar Usuario', 'url'=>array('admin')),
);
?>

<h1>Novo Usuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>