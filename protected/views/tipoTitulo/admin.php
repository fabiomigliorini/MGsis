<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Tipo Titulo';
$this->breadcrumbs=array(
	'Tipo Titulo'=>array('index'),
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
	$.fn.yiiGridView.update('tipo-titulo-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Tipo Titulo</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tipo-titulo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codtipotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'tipotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'pagar',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'receber',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacoes',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codtipomovimentotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'debito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'credito',
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
