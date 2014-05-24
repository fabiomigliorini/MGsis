<?php
$this->pagetitle = Yii::app()->name . ' - Novo Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Nota Fiscal Produto Barra'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo NotaFiscalProdutoBarra</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>