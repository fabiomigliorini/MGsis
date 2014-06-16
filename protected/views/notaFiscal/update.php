<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo)=>array('view','id'=>$model->codnotafiscal),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscal)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Nota Fiscal <?php echo 	Yii::app()->format->formataNumeroNota($model->emitida, $model->serie, $model->numero, $model->modelo); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>