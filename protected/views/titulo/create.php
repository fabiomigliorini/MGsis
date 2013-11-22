<?php
/* @var $this TituloController */
/* @var $model Titulo */

$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	'Novo',
);

$this->menu=array(
	array('label'=>'Listagem de Titulo', 'url'=>array('index')),
	array('label'=>'Gerenciar Titulo', 'url'=>array('admin')),
);
?>

<h1>Novo Titulo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>