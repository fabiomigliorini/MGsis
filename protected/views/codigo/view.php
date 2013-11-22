<?php
/* @var $this CodigoController */
/* @var $model Codigo */

$this->breadcrumbs=array(
	'Codigo'=>array('index'),
	$model->tabela,
);

$this->menu=array(
	array('label'=>'Listagem de Codigo', 'url'=>array('index')),
	array('label'=>'Novo Codigo', 'url'=>array('create')),
	array('label'=>'Alterar Codigo', 'url'=>array('update', 'id'=>$model->tabela)),
	array('label'=>'Apagar Codigo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tabela),'confirm'=>'Tem certeza que deseja apagar este registro?')),
	array('label'=>'Gerenciar Codigo', 'url'=>array('admin')),
);
?>

<h1>Detalhes do Codigo #<?php echo $model->tabela; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tabela',
		'codproximo',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
	),
)); ?>
