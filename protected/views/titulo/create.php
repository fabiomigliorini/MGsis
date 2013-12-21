<?php
$this->pagetitle = Yii::app()->name . ' - Novo Titulo';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Titulo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>