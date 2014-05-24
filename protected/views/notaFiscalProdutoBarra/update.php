<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Nota Fiscal Produto Barra'=>array('index'),
	$model->codnotafiscalprodutobarra=>array('view','id'=>$model->codnotafiscalprodutobarra),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscalprodutobarra)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NotaFiscalProdutoBarra <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscalprodutobarra)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>