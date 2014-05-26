<?php
$this->pagetitle = Yii::app()->name . ' - Novo Sub Grupos de Produtos';
$this->breadcrumbs=array(
	'Sub Grupos de Produtos'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Sub Grupos de Produtos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>