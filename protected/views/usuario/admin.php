<?php
$this->pagetitle = Yii::app()->name . ' - Gerenciar Usuario';
$this->breadcrumbs=array(
	'Usuario'=>array('index'),
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
	$.fn.yiiGridView.update('usuario-grid', {
			data: $(this).serialize()
		});
		return false;
		});
");
?>

<h1>Gerenciar Usuario</h1>


<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		'codusuario',
		array(
			'name'=>'usuario',
			'htmlOptions'=> array('style'=>'font-weight: bold'),
			),
		array(
			'name'=>'fantasia_busca',
			'header'=>'Pessoa',
			'value'=>'isset($data->codpessoa)?$data->Pessoa->fantasia:Null',
			),
		array(
			'name'=>'codfilial',
			'filter'=>CHtml::listData(Filial::model()->findAll(), 'codfilial', 'filial'),
			'value'=>'isset($data->codfilial)?$data->Filial->filial:Null',
			),
		array(
			'name'=>'codecf',
			'filter'=>CHtml::listData(Ecf::model()->findAll(), 'codecf', 'ecf'),
			'value'=>'isset($data->codecf)?$data->Ecf->ecf:Null',
			),
		array(
			'name'=>'codoperacao',
			'filter'=>CHtml::listData(Operacao::model()->findAll(), 'codoperacao', 'operacao'),
			'value'=>'isset($data->codoperacao)?$data->Operacao->operacao:Null',
			),
		array(
			'name'=>'codportador',
			'filter'=>CHtml::listData(Portador::model()->findAll(), 'codportador', 'portador'),
			'value'=>'isset($data->codportador)?$data->Portador->portador:Null',
			),
		array(
			'name'=>'impressoratelanegocio',
			'header'=>'Impr',
			),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			),
		),
	)); 
?>
