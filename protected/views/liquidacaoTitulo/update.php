<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Liquidação de Títulos';
$this->breadcrumbs=array(
	'Liquidação de Títulos'=>array('index'),
	$model->codliquidacaotitulo=>array('view','id'=>$model->codliquidacaotitulo),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codliquidacaotitulo)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar LiquidacaoTitulo <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codliquidacaotitulo)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>