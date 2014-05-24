<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Notas Fiscais';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('nota-fiscal-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Notas Fiscais</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'nota-fiscal-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnotafiscal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnaturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emitida',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfechave',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfeimpressa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'serie',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'numero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emissao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'saida',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codfilial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacoes',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'volumes',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'fretepagar',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfereciboenvio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfedataenvio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfeautorizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfedataautorizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valorfrete',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valorseguro',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valordesconto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valoroutras',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfecancelamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfedatacancelamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfeinutilizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfedatainutilizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'justificativa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valorprodutos',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valortotal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsbase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsvalor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsstbase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsstvalor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipibase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipivalor',
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
