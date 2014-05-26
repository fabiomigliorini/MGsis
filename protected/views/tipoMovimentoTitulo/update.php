<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tipo Movimento Título';
$this->breadcrumbs=array(
	'Tipo Movimento Título'=>array('index'),
	$model->tipomovimentotitulo=>array('view','id'=>$model->codtipomovimentotitulo),
	'Alterar Tipo Movimento Título',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtipomovimentotitulo)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Tipo Movimento Título <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtipomovimentotitulo)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>