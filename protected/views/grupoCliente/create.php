<?php
$this->pagetitle = Yii::app()->name . ' - Novo Grupo do Cliente';
$this->breadcrumbs=array(
	'Grupo do Cliente'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Grupo do Cliente</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>