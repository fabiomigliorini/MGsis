<?php
/* @var $this OperacaoController */
/* @var $model Operacao */

$this->pagetitle = Yii::app()->name . ' - Novo Operacao';

$this->breadcrumbs=array(
	'Operacao'=>array('index'),
	'Novo',
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Novo Operacao</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>