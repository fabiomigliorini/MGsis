<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Estado';
$this->breadcrumbs=array(
	'Estado'=>array('index'),
	$model->estado=>array('view','id'=>$model->estado),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codestado)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Estado <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codestado)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>