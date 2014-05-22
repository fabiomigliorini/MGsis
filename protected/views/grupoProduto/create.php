<?php
$this->pagetitle = Yii::app()->name . ' - Novo Grupo de Produtos';
$this->breadcrumbs=array(
	'Grupo de Produtos'=>array('index'),
	'Grupo de Produtos',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Grupo de Produtos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>