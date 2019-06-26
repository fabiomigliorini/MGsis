<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Natureza de Operação';
$this->breadcrumbs=array(
	'Naturezas de Operação'=>array('index'),
	$model->naturezaoperacao=>array('view','id'=>$model->codnaturezaoperacao),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnaturezaoperacao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Natureza Operação <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnaturezaoperacao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>