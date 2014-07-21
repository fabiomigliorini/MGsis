<?php
$this->pagetitle = Yii::app()->name . ' - Novo Produto Historico Preco';
$this->breadcrumbs=array(
	'Produto Historico Preco'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo ProdutoHistoricoPreco</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>