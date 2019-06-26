<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tipo do Produto';
$this->breadcrumbs=array(
	'Tipos de Produtos'=>array('index'),
	$model->tipoproduto=>array('view','id'=>$model->codtipoproduto),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtipoproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>
		Alterar Tipo do Produto <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtipoproduto)); ?>
	</h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>