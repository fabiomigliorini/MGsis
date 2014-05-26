<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Tributacao Natureza Operacao';
$this->breadcrumbs=array(
	'Tributacao Natureza Operacao'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tributacao-natureza-operacao-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Tributacao Natureza Operacao</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tributacao-natureza-operacao-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codtributacaonaturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtributacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnaturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcfop',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsbase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmspercentual',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'codestado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'csosn',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtipoproduto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acumuladordominiovista',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acumuladordominioprazo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'historicodominio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'movimentacaofisica',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'movimentacaocontabil',
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
