<?php
/* @var $this CodigoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Codigo',
);

$this->menu=array(
	array('label'=>'Novo Codigo', 'url'=>array('create')),
	array('label'=>'Gerenciar Codigo', 'url'=>array('admin')),
);
?>

<h1>Codigo</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
