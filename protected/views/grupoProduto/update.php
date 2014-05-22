<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Grupo de Produtos';
$this->breadcrumbs=array(
	'Grupo de Produts'=>array('index'),
	$model->grupoproduto=>array('view','id'=>$model->grupoproduto),
	'Alterar Grupo de Produto',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codgrupoproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Grupo de Produto <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codgrupoproduto)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>