<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Produto Historico Preco';
$this->breadcrumbs=array(
	'Produto Historico Preco'=>array('index'),
	$model->codprodutohistoricopreco=>array('view','id'=>$model->codprodutohistoricopreco),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codprodutohistoricopreco)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar ProdutoHistoricoPreco <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codprodutohistoricopreco)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>