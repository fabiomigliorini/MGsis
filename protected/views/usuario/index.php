<?php
/* @var $this UsuarioController */
/* @var $dataProvider CActiveDataProvider */
$this->pagetitle = Yii::app()->name . ' - Usuario';

$this->breadcrumbs=array(
	'Usuario',
);

$this->menu=array(
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Usuario</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); 
?>