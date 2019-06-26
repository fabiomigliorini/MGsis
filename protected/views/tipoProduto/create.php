<?php
$this->pagetitle = Yii::app()->name . ' - Novo Tipo de Produto';
$this->breadcrumbs=array(
	'Tipos de Produtos'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Tipo de Produto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>