<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Cheque';
$this->breadcrumbs=array(
	'Cheque'=>array('index'),
	$model->codcheque=>array('view','id'=>$model->codcheque),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codcheque)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Cheque <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codcheque)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>