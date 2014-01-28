<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Liquidação de Títulos';
$this->breadcrumbs=array(
	'Liquidação de Títulos'=>array('index'),
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
	$.fn.yiiGridView.update('liquidacao-titulo-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Liquidação de Títulos</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'liquidacao-titulo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codliquidacaotitulo',
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
			'name'=>'codportador',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codusuario',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'estornado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codusuarioestorno',
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
			'name'=>'codpessoa',
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
