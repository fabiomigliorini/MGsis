<?php
$this->pagetitle = Yii::app()->name . ' - Novo Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Pessoa</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>