<?php
/* @var $this CodigoController */
/* @var $model Codigo */

$this->breadcrumbs=array(
	'Codigo'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem de Codigo', 'url'=>array('index')),
	array('label'=>'Novo Codigo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#codigo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar Codigo</h1>

<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'codigo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tabela',
		'codproximo',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
