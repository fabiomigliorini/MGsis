<?php
$this->pagetitle = Yii::app()->name . ' - Novo NCM';
$this->breadcrumbs=array(
	'NCM'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo NCM</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>