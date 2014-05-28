<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Forma Pagamento';
$this->breadcrumbs=array(
	'Forma Pagamento'=>array('index'),
	$model->codformapagamento=>array('view','id'=>$model->codformapagamento),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codformapagamento)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar FormaPagamento <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codformapagamento)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>