<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal Carta Correcao';
$this->breadcrumbs=array(
	'Nota Fiscal Carta Correcao'=>array('index'),
	$model->codnotafiscalcartacorrecao=>array('view','id'=>$model->codnotafiscalcartacorrecao),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscalcartacorrecao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NotaFiscalCartaCorrecao <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnotafiscalcartacorrecao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>