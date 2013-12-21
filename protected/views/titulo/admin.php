<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Titulo';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('titulo-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Titulo</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'titulo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codtitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtipotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codfilial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codportador',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcontacontabil',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'numero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'fatura',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'transacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'sistema',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emissao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vencimento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vencimentooriginal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'debito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'credito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'gerencial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'boleto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nossonumero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'debitototal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'creditototal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'saldo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'debitosaldo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'creditosaldo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'transacaoliquidacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnegocioformapagamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtituloagrupamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'remessa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'estornado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>
