<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario,
);

$this->menu=array(
	array('label'=>'Listagem de Usuario', 'url'=>array('index')),
	array('label'=>'Novo Usuario', 'url'=>array('create')),
	array('label'=>'Alterar Usuario', 'url'=>array('update', 'id'=>$model->codusuario)),
	array('label'=>'Apagar Usuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codusuario),'confirm'=>'Tem certeza que deseja apagar este registro?')),
	array('label'=>'Gerenciar Usuario', 'url'=>array('admin')),
);
?>

<h1>Detalhes do Usuario #<?php echo $model->codusuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codusuario',
		'usuario',
		'senha',
		'codecf',
		'codfilial',
		'codoperacao',
		'codpessoa',
		'impressoratelanegocio',
		'codportador',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
	),
)); ?>
