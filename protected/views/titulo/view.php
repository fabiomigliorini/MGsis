<?php
/* @var $this TituloController */
/* @var $model Titulo */

$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->codtitulo,
);

$this->menu=array(
	array('label'=>'Listagem de Titulo', 'url'=>array('index')),
	array('label'=>'Novo Titulo', 'url'=>array('create')),
	array('label'=>'Alterar Titulo', 'url'=>array('update', 'id'=>$model->codtitulo)),
	array('label'=>'Apagar Titulo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codtitulo),'confirm'=>'Tem certeza que deseja apagar este registro?')),
	array('label'=>'Gerenciar Titulo', 'url'=>array('admin')),
);
?>

<h1>Detalhes do Titulo #<?php echo $model->codtitulo; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codtitulo',
		'codtipotitulo',
		'codfilial',
		'codportador',
		'codpessoa',
		'codcontacontabil',
		'numero',
		'fatura',
		'transacao',
		'sistema',
		'emissao',
		'vencimento',
		'vencimentooriginal',
		'debito',
		'credito',
		'gerencial',
		'observacao',
		'boleto',
		'nossonumero',
		'debitototal',
		'creditototal',
		'saldo',
		'debitosaldo',
		'creditosaldo',
		'transacaoliquidacao',
		'codnegocioformapagamento',
		'codtituloagrupamento',
		'remessa',
		'estornado',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
	),
)); ?>
