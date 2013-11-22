<?php
/* @var $this UsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Usuario',
);

$this->menu=array(
	array('label'=>'Novo Usuario', 'url'=>array('create')),
	array('label'=>'Gerenciar Usuario', 'url'=>array('admin')),
);
?>

<h1>Usuario</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
