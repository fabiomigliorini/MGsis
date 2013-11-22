<?php
/* @var $this CodigoController */
/* @var $model Codigo */

$this->breadcrumbs=array(
	'Codigo'=>array('index'),
	$model->tabela=>array('view','id'=>$model->tabela),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem de Codigo', 'url'=>array('index')),
	array('label'=>'Novo Codigo', 'url'=>array('create')),
	array('label'=>'Detalhes do Codigo', 'url'=>array('view', 'id'=>$model->tabela)),
	array('label'=>'Gerenciar Codigo', 'url'=>array('admin')),
);
?>

<h1>Alterar Codigo #<?php echo $model->tabela; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>