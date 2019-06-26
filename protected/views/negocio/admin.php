<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Negócio';
$this->breadcrumbs=array(
	'Negócio'=>array('index'),
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
	$.fn.yiiGridView.update('negocio-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Negocio</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'negocio-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codnegocio',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codfilial',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'lancamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoavendedor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'codnegociostatus',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacoes',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codusuario',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valordesconto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'entrega',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'acertoentrega',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codusuarioacertoentrega',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codnaturezaoperacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valorprodutos',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valortotal',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valoraprazo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'valoravista',
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
