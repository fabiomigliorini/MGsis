<?php
$this->pagetitle = Yii::app()->name . ' - Nova Marca';
$this->breadcrumbs=array(
	'Marca'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Marca</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>