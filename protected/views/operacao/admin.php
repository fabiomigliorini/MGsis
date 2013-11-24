<?php
/* @var $this OperacaoController */
/* @var $model Operacao */

$this->pagetitle = Yii::app()->name . ' - Gerenciar Operacao';

$this->breadcrumbs=array(
	'Operacao'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Novo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#operacao-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar Operacao</h1>

<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'operacao-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codoperacao',
		'operacao',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
