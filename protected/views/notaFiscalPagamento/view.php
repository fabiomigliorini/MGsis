<?php
$this->breadcrumbs=array(
	'Nota Fiscal Pagamentos'=>array('index'),
	$model->codnotafiscalpagamento,
);

$this->menu=array(
array('label'=>'List NotaFiscalPagamento','url'=>array('index')),
array('label'=>'Create NotaFiscalPagamento','url'=>array('create')),
array('label'=>'Update NotaFiscalPagamento','url'=>array('update','id'=>$model->codnotafiscalpagamento)),
array('label'=>'Delete NotaFiscalPagamento','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codnotafiscalpagamento),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage NotaFiscalPagamento','url'=>array('admin')),
);
?>

<h1>View NotaFiscalPagamento #<?php echo $model->codnotafiscalpagamento; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'codnotafiscalpagamento',
		'codnotafiscal',
		'avista',
		'tipo',
		'valorpagamento',
		'troco',
		'integracao',
		'codpessoa',
		'bandeira',
		'autorizacao',
		'criacao',
		'codusuariocriacao',
		'alteracao',
		'codusuarioalteracao',
),
)); ?>
