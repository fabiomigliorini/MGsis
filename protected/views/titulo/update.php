<?php
/* @var $this TituloController */
/* @var $model Titulo */

$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->codtitulo=>array('view','id'=>$model->codtitulo),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem de Titulo', 'url'=>array('index')),
	array('label'=>'Novo Titulo', 'url'=>array('create')),
	array('label'=>'Detalhes do Titulo', 'url'=>array('view', 'id'=>$model->codtitulo)),
	array('label'=>'Gerenciar Titulo', 'url'=>array('admin')),
);
?>

<h1>Alterar Titulo #<?php echo $model->codtitulo; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>