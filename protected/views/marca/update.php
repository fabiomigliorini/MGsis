<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Marca';
$this->breadcrumbs=array(
	'Marca'=>array('index'),
	$model->marca=>array('view','id'=>$model->codmarca),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codmarca)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Marca <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codmarca)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>