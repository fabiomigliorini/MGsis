<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Forma de Pagamento';
$this->breadcrumbs=array(
	'Forma de Pagamento'=>array('index'),
	$model->formapagamento=>array('view','id'=>$model->formapagamento),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codformapagamento)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Forma de Pagamento <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codformapagamento)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>