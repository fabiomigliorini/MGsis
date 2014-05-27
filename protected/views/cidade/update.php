<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Cidade';
$this->breadcrumbs=array(
	'Cidade'=>array('index'),
	$model->cidade=>array('view','id'=>$model->codcidade),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codcidade)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Cidade #<?php echo $model->codcidade; ?></h1>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>