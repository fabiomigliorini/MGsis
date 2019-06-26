<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Órgão Emissor de Certidão ';
$this->breadcrumbs=array(
	'Órgão Emissor de Certidão'=>array('index'),
	Yii::app()->format->formataCodigo($model->codcertidaoemissor)=>array('view','id'=>$model->codcertidaoemissor),
	'Alterar',
);

	$this->menu=array(
		array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
		array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
		array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codcertidaoemissor)),
		//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Órgão Emissor de Certidão <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codcertidaoemissor)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>
