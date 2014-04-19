<?php
$this->pagetitle = Yii::app()->name . ' - Novo Código de Barras';

$this->breadcrumbs=array(
	'Produtos'=>array('produto/index'),
	$model->Produto->produto => array('produto/view', 'id'=>$model->codproduto),
	'Novo Código de Barras',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('produto/view', 'id'=>$model->codproduto)),
);

?>

<h1>Novo Código de Barras <?php echo CHtml::encode($model->Produto->produto); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>