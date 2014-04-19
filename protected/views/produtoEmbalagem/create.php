<?php
$this->pagetitle = Yii::app()->name . ' - Nova Embalagem de Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('produto/index'),
	$model->Produto->produto => array('produto/view', 'id'=>$model->codproduto),
	'Nova Embalagem',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('produto/view', 'id'=>$model->codproduto)),
);
?>

<h1>Nova Embalagem <?php echo CHtml::encode($model->Produto->produto); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>