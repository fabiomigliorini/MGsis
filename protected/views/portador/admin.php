<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Portador';
$this->breadcrumbs=array(
	'Portador'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('portador-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Portador</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'portador-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codportador',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'portador',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codbanco',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'agencia',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'agenciadigito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'conta',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'contadigito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emiteboleto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codfilial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'convenio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'diretorioremessa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'diretorioretorno',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'carteira',
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
