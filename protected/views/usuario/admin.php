<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Listagem de Usuario', 'url'=>array('index')),
	array('label'=>'Novo Usuario', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#usuario-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar Usuario</h1>

<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codusuario',
		'usuario',
		'senha',
		'codecf',
		'codfilial',
		'codoperacao',
		/*
		'codpessoa',
		'impressoratelanegocio',
		'codportador',
		'alteracao',
		'codusuarioalteracao',
		'criacao',
		'codusuariocriacao',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
