<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar NFe\'s de Terceiro';
$this->breadcrumbs=array(
	'NFe\'s de Terceiro'=>array('index'),
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
	$.fn.yiiGridView.update('nfe-terceiro-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar NFe's de Terceiro</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'nfe-terceiro-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnfeterceiro',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nsu',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfechave',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cnpj',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ie',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emitente',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emissao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nfedataautorizacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valortotal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'indsituacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'indmanifestacao',
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
