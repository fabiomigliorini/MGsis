<?php
$this->pagetitle = Yii::app()->name . ' - Alterar NCM';
$this->breadcrumbs=array(
	'NCM'=>array('index'),
	$model->ncm=>array('view','id'=>$model->codncm),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codncm)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar NCM 
		<?php 
		echo CHtml::encode(Yii::app()->format->formataCodigo($model->ncm)); 
		?>
	</h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>