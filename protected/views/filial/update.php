<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Filial';
$this->breadcrumbs=array(
	'Filial'=>array('index'),
	$model->filial=>array('view','id'=>$model->codfilial),
	'Alterar Filial',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codfilial)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Filial <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codfilial)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>