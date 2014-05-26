<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Sub Grupos de Produtos';
$this->breadcrumbs=array(
	'Sub Grupos de Produtos'=>array('index'),
	$model->subgrupoproduto=>array('view','id'=>$model->codsubgrupoproduto),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codsubgrupoproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Sub Grupo de Produto <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codsubgrupoproduto)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>