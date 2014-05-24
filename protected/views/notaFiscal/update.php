<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Notas Fiscais';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	$model->codnotafiscal=>array('view','id'=>$model->codnotafiscal),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscal)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NotaFiscal <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscal)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>