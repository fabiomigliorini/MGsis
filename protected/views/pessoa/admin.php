<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
	'Gerenciar',
);

$this->menu=array(
	array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
	);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
	$('.search-form').toggle();
		return false;
		});
	$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('pessoa-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Pessoa</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'pessoa-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codpessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'pessoa',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'fantasia',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cadastro',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'inativo',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cliente',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			/*
		array(
			'name'=>'fornecedor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'fisica',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codsexo',
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
			'name'=>'consumidor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'contato',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codestadocivil',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'conjuge',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'endereco',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'numero',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'complemento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcidade',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'bairro',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cep',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'enderecocobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'numerocobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'complementocobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codcidadecobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'bairrocobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'cepcobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'telefone1',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'telefone2',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'telefone3',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'email',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emailnfe',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'emailcobranca',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'codformapagamento',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'credito',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'creditobloqueado',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'observacoes',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'mensagemvenda',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'vendedor',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'rg',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'desconto',
			'htmlOptions'=> array('class'=>'span1'),
			),	
			array(
			'name'=>'notafiscal',
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
