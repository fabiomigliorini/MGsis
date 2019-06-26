<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Nota Fiscal Produto Barra'=>array('index'),
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
	$.fn.yiiGridView.update('nota-fiscal-produto-barra-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Nota Fiscal Produto Barra</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'nota-fiscal-produto-barra-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnotafiscalprodutobarra',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnotafiscal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codprodutobarra',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcfop',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'descricaoalternativa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'quantidade',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'valorunitario',
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
			'name'=>'icmspercentual',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsvalor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipibase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipipercentual',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipivalor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsstbase',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsstpercentual',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'icmsstvalor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'csosn',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnegocioprodutobarra',
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
