<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Registro Spc';
$this->breadcrumbs=array(
	'Registro Spc'=>array('index'),
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
	$.fn.yiiGridView.update('registro-spc-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Registro Spc</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'registro-spc-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codregistrospc',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'inclusao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'baixa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>
