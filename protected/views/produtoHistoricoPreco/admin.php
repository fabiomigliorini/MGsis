<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Produto Historico Preco';
$this->breadcrumbs=array(
	'Produto Historico Preco'=>array('index'),
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
	$.fn.yiiGridView.update('produto-historico-preco-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Produto Historico Preco</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'produto-historico-preco-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codprodutohistoricopreco',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codproduto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codprodutoembalagem',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codusuario',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'precoantigo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'preconovo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'data',
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
