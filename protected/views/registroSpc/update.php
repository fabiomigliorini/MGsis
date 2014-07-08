<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Registro SPC';
$this->breadcrumbs=array(
	'Registro SPC'=>array('index'),
	'Inclusão'=>array('view','id'=>$model->codregistrospc),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codregistrospc)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Registro SPC</h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>