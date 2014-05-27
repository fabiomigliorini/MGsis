<?php
$this->pagetitle = Yii::app()->name . ' - Nova Unidade de Medida';
$this->breadcrumbs=array(
	'Unidade de Medida'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Unidade de Medida</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>