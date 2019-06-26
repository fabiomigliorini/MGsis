<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('index'),
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
	$.fn.yiiGridView.update('produto-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Produto</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'produto-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codproduto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'produto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'referencia',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codunidademedida',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codsubgrupoproduto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codmarca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'preco',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'importado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ncm',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtributacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'inativo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtipoproduto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'site',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'descricaosite',
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
