<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Produto Barra';
$this->breadcrumbs=array(
	'Produto Barra'=>array('index'),
	$model->codprodutobarra=>array('view','id'=>$model->codprodutobarra),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codprodutobarra)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar ProdutoBarra <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codprodutobarra)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>