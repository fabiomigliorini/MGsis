<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Título';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->numero=>array('view','id'=>$model->codtitulo),
	'Alterar',
);

	$this->menu=array(
		array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
		array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
		array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtitulo)),
		//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

	<h1>Alterar Título <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtitulo)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>