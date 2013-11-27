<?php
$this->breadcrumbs=array(
	'Codigos'=>array('index'),
	$model->tabela=>array('view','id'=>$model->tabela),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Codigo','url'=>array('index')),
	array('label'=>'Create Codigo','url'=>array('create')),
	array('label'=>'View Codigo','url'=>array('view','id'=>$model->tabela)),
	array('label'=>'Manage Codigo','url'=>array('admin')),
	);
	?>

	<h1>Update Codigo <?php echo $model->tabela; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>