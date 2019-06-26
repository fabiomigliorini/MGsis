<?php
/* @var $this OperacaoController */
/* @var $model Operacao */

$this->pagetitle = Yii::app()->name . ' - Operacao #' . $model->codusuario;


$this->breadcrumbs=array(
	'Operacao'=>array('index'),
	$model->codoperacao,
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Alterar', 'url'=>array('update', 'id'=>$model->codoperacao)),
	array('label'=>'Excluir', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codoperacao),'confirm'=>'Tem certeza que deseja excluir este registro?')),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Operacao #<?php echo $model->codoperacao; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codoperacao',
		'operacao',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
	),
)); ?>
