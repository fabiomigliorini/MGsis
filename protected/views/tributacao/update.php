<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tributação';
$this->breadcrumbs=array(
	'Tributações'=>array('index'),
	$model->tributacao=>array('view','id'=>$model->codtributacao),
	'Alterar Tributação',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtributacao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Tributação <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtributacao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>