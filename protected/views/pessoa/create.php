<?php
$this->pagetitle = Yii::app()->name . ' - Nova Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Pessoa</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>