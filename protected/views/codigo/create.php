<?php
/* @var $this CodigoController */
/* @var $model Codigo */

$this->breadcrumbs=array(
	'Codigo'=>array('index'),
	'Novo',
);

$this->menu=array(
	array('label'=>'Listagem de Codigo', 'url'=>array('index')),
	array('label'=>'Gerenciar Codigo', 'url'=>array('admin')),
);
?>

<h1>Novo Codigo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>