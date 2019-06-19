<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Pessoa Certidao';
$this->breadcrumbs=array(
	'Pessoa Certidao'=>array('index'),
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
	$.fn.yiiGridView.update('pessoa-certidao-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Pessoa Certidao</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pessoa-certidao-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codpessoacertidao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcertidaoemissor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'numero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'autenticacao',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'validade',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'inativo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcertidaotipo',
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
