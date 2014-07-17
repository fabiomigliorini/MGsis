<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Nfe Terceiro Item';
$this->breadcrumbs=array(
	'Nfe Terceiro Item'=>array('index'),
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
	$.fn.yiiGridView.update('nfe-terceiro-item-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Nfe Terceiro Item</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'nfe-terceiro-item-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnfeterceiroitem',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnfeterceiro',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'nitem',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cprod',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'xprod',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cean',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'ncm',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cfop',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ucom',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'qcom',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vuncom',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vprod',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ceantrib',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'utrib',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'qtrib',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vuntrib',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cst',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'csosn',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vbc',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'picms',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vicms',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vbcst',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'picmsst',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vicmsst',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipivbc',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipipipi',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'ipivipi',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codprodutobarra',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'margem',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'complemento',
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
