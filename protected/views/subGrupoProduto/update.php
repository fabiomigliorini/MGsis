<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Sub Grupo Produto';
$this->breadcrumbs=array(
	'Sub Grupo Produto'=>array('index'),
	$model->codsubgrupoproduto=>array('view','id'=>$model->codsubgrupoproduto),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codsubgrupoproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar SubGrupoProduto <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codsubgrupoproduto)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>