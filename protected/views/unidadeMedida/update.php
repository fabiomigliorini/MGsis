<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Unidade de Medida';
$this->breadcrumbs=array(
	'Unidade de Medida'=>array('index'),
	$model->unidademedida=>array('view','id'=>$model->codunidademedida),
	'Alterar Unidade de Medida',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codunidademedida)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Unidade de Medida <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codunidademedida)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>