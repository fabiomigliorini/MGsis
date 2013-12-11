<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
	CHtml::encode($model->fantasia) =>array('view','id'=>$model->codpessoa),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codpessoa)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Pessoa <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codpessoa)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>