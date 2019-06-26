<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Tipo Movimento Titulo';
$this->breadcrumbs=array(
	'Tipo Movimento Titulo'=>array('index'),
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
	$.fn.yiiGridView.update('tipo-movimento-titulo-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Tipo Movimento Titulo</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tipo-movimento-titulo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codtipomovimentotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'tipomovimentotitulo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'implantacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ajuste',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'armotizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'juros',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'desconto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'pagamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'estorno',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacao',
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
