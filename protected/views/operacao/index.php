<?php
/* @var $this OperacaoController */
/* @var $dataProvider CActiveDataProvider */
$this->pagetitle = Yii::app()->name . ' - Operacao';

$this->breadcrumbs=array(
	'Operacao',
);

$this->menu=array(
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Operacao</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
