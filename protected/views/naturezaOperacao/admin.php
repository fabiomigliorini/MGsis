<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Natureza Operacao';
$this->breadcrumbs=array(
	'Natureza Operacao'=>array('index'),
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
	$.fn.yiiGridView.update('natureza-operacao-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Natureza Operacao</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'natureza-operacao-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnaturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'naturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emitida',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacoesnf',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>
