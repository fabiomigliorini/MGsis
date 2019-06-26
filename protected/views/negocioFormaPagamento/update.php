<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Negocio Forma Pagamento';
$this->breadcrumbs=array(
	'Negocio Forma Pagamento'=>array('index'),
	$model->codnegocioformapagamento=>array('view','id'=>$model->codnegocioformapagamento),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnegocioformapagamento)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NegocioFormaPagamento <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codnegocioformapagamento)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>