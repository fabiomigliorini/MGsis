<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Filial';
$this->breadcrumbs=array(
	'Filial'=>array('index'),
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
	$.fn.yiiGridView.update('filial-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Filial</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'filial-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codfilial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codempresa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'filial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emitenfe',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acbrnfemonitorcaminho',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'acbrnfemonitorcaminhorede',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acbrnfemonitorbloqueado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acbrnfemonitorcodusuario',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'empresadominio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acbrnfemonitorip',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acbrnfemonitorporta',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'odbcnumeronotafiscal',
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
