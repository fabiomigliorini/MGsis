<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Conta Contábil';
$this->breadcrumbs=array(
	'Conta Contábil'=>array('index'),
	$model->contacontabil=>array('view','id'=>$model->codcontacontabil),
	'Alterar Conta Contábil',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codcontacontabil)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Conta Contábil <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codcontacontabil)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>