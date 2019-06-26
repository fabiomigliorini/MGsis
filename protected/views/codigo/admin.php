<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Codigo';
$this->breadcrumbs=array(
	'Codigo'=>array('index'),
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
	$.fn.yiiGridView.update('codigo-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Codigo</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'codigo-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover',
	'filter'=>$model,
	'template'=>'{pager} {items} {pager}',
	'columns'=>array(
		'tabela',
		'codproximo',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); 
?>
