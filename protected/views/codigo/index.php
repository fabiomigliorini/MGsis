<?php
/* @var $this CodigoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Codigos',
);

$this->menu=array(
	array('label'=>'Create Codigo', 'url'=>array('create')),
	array('label'=>'Manage Codigo', 'url'=>array('admin')),
);
?>

<h1>Codigos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
