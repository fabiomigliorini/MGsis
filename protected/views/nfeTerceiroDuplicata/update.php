<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nfe Terceiro Duplicata';
$this->breadcrumbs=array(
	'Nfe Terceiro Duplicata'=>array('index'),
	$model->codnfeterceiroduplicata=>array('view','id'=>$model->codnfeterceiroduplicata),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiroduplicata)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NfeTerceiroDuplicata <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnfeterceiroduplicata)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>