<?php
$this->pagetitle = Yii::app()->name . ' - Novo Portador';
$this->breadcrumbs=array(
	'Portador'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Portador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>