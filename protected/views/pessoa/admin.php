<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Pessoa';
$this->breadcrumbs=array(
	'Pessoa'=>array('index'),
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
	'type'=>'striped condensed hover',
	'filter'=>$model,
	'template'=>'{pager} {items} {pager}',
	'columns'=>array(
		'codpessoa',
		'pessoa',
		'fantasia',
		'cadastro',
		'inativo',
		'cliente',
		/*
		'fornecedor',
		'fisica',
		'codsexo',
		'cnpj',
		'ie',
		'consumidor',
		'contato',
		'codestadocivil',
		'conjuge',
		'endereco',
		'numero',
		'complemento',
		'codcidade',
		'bairro',
		'cep',
		'enderecocobranca',
		'numerocobranca',
		'complementocobranca',
		'codcidadecobranca',
		'bairrocobranca',
		'cepcobranca',
		'telefone1',
		'telefone2',
		'telefone3',
		'email',
		'emailnfe',
		'emailcobranca',
		'codformapagamento',
		'credito',
		'creditobloqueado',
		'observacoes',
		'mensagemvenda',
		'vendedor',
		'rg',
		'desconto',
		'notafiscal',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); 
?>
