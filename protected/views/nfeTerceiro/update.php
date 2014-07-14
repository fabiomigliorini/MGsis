<?php
$this->pagetitle = Yii::app()->name . ' - Alterar NFe de Terceiro';
$this->breadcrumbs=array(
	'NFe\'s de Terceiros'=>array('index'),
	$model->codnfeterceiro=>array('view','id'=>$model->codnfeterceiro),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnfeterceiro)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NFe de Terceiro <?php echo CHtml::encode($model->nfechave); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>