<?php
$this->pagetitle = Yii::app()->name . ' - Novo Produto Barra';
$this->breadcrumbs=array(
	'Produto Barra'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo ProdutoBarra</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>