<?php
$this->pagetitle = Yii::app()->name . ' - Informar Detalhes NFe de Terceiro';
$this->breadcrumbs=array(
	'NFe de Terceiros'=>array('index'),
	$model->nfechave=>array('view','id'=>$model->codnfeterceiro),
	'Informar Detalhes',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiro)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Informar Detalhes <?php echo CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>