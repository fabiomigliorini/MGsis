<?php
$this->pagetitle = Yii::app()->name . ' - Novo Negocio Produto Barra';
$this->breadcrumbs=array(
	'Negocio Produto Barra'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo NegocioProdutoBarra</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>