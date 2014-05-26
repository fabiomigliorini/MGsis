<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tributacao Natureza Operacao';
$this->breadcrumbs=array(
	'Tributacao Natureza Operacao'=>array('index'),
	$model->codtributacaonaturezaoperacao=>array('view','id'=>$model->codtributacaonaturezaoperacao),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtributacaonaturezaoperacao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar TributacaoNaturezaOperacao <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtributacaonaturezaoperacao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>