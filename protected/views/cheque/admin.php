<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Cheque';
$this->breadcrumbs=array(
	'Cheque'=>array('index'),
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
	$.fn.yiiGridView.update('cheque-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Cheque</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'cheque-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codcheque',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cmc7',
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
			'name'=>'contacorrente',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emitente',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'numero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emissao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vencimento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'repasse',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'destino',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'devolucao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'motivodevolucao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'lancamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cancelamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valor',
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
