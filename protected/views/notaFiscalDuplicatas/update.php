<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal Duplicatas';
$this->breadcrumbs=array(
	'Nota Fiscal Duplicatas'=>array('index'),
	$model->codnotafiscalduplicatas=>array('view','id'=>$model->codnotafiscalduplicatas),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscalduplicatas)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NotaFiscalDuplicatas <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscalduplicatas)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>