<?php
/* @var $this TituloController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Titulo',
);

$this->menu=array(
	array('label'=>'Novo Titulo', 'url'=>array('create')),
	array('label'=>'Gerenciar Titulo', 'url'=>array('admin')),
);
?>

<h1>Titulo</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
