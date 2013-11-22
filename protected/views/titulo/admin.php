<?php
/* @var $this TituloController */
/* @var $model Titulo */

$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem de Titulo', 'url'=>array('index')),
	array('label'=>'Novo Titulo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#titulo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar Titulo</h1>

<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'titulo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codtitulo',
		'codtipotitulo',
		'codfilial',
		'codportador',
		'codpessoa',
		'codcontacontabil',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
