<?php
$this->pagetitle = Yii::app()->name . ' - Nova Natureza da Operação';
$this->breadcrumbs=array(
	'Natureza da Operação'=>array('index'),
	'Nova Natureza da Operação',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Natureza da Operação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>