<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Negocio Produto Barra';
$this->breadcrumbs=array(
	'Negocio Produto Barra'=>array('index'),
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
	$.fn.yiiGridView.update('negocio-produto-barra-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Negocio Produto Barra</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'negocio-produto-barra-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnegocioprodutobarra',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnegocio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'quantidade',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valorunitario',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valortotal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codprodutobarra',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>
