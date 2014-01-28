<?php
$this->pagetitle = Yii::app()->name . ' - Nova Liquidação de Títulos';
$this->breadcrumbs=array(
	'Liquidação de Títulos'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Liquidação de Títulos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>