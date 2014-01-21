<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Agrupamento de Títulos';
$this->breadcrumbs=array(
	'Agrupamento de Títulos'=>array('index'),
	$model->codtituloagrupamento=>array('view','id'=>$model->codtituloagrupamento),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtituloagrupamento)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar TituloAgrupamento <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtituloagrupamento)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>