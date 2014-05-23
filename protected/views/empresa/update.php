<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Empresa';
$this->breadcrumbs=array(
	'Empresa'=>array('index'),
	$model->empresa=>array('view','id'=>$model->codempresa),
	'Alterar Empresa',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codempresa)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Empresa <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codempresa)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>