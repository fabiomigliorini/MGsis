<?php
$this->breadcrumbs=array(
	'Codigos'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Codigo','url'=>array('index')),
array('label'=>'Manage Codigo','url'=>array('admin')),
);
?>

<h1>Create Codigo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>