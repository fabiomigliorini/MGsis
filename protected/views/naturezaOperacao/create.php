<?php
$this->pagetitle = Yii::app()->name . ' - Nova Natureza de Operação';
$this->breadcrumbs=array(
	'Naturezas de Operação'=>array('index'),
	'Nova Natureza de Operação',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Natureza de Operação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>