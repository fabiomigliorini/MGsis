<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Agrupamento de Títulos';
$this->breadcrumbs=array(
	'Agrupamento de Títulos'=>array('index'),
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
	$.fn.yiiGridView.update('titulo-agrupamento-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Agrupamento de Títulos</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'titulo-agrupamento-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codtituloagrupamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emissao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cancelamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>
