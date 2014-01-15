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
/*
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
 * 
 */
?>

<h1>Gerenciar Usuario</h1>

<?php /*
<?php echo CHtml::link('Busca Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/?>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed hover bordered',
	'filter'=>$model,
	'template'=>'{items} {pager}',
	'columns'=>array(
		array(
			'name'=>'codusuario',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'name'=>'usuario',
			'htmlOptions'=> array('class'=>'span1','style'=>'font-weight: bold'),
			),
		array(
			'name'=>'fantasia_busca',
			'header'=>'Pessoa',
			'value'=>'isset($data->codpessoa)?$data->Pessoa->fantasia:Null',
			'htmlOptions'=> array('class'=>'span2'),
			),
		array(
			'name'=>'codfilial',
			'filter'=>Filial::getListaCombo(),
			'value'=>'isset($data->codfilial)?$data->Filial->filial:Null',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'name'=>'codecf',
			'filter'=>Ecf::getListaCombo(),
			'value'=>'isset($data->codecf)?$data->Ecf->ecf:Null',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'name'=>'codoperacao',
			'filter'=>Operacao::getListaCombo(),
			'value'=>'isset($data->codoperacao)?$data->Operacao->operacao:Null',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'name'=>'codportador',
			'filter'=>Portador::getListaCombo(),
			'value'=>'isset($data->codportador)?$data->Portador->portador:Null',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'name'=>'impressoratelanegocio',
			'header'=>'Impr',
			'htmlOptions'=> array('class'=>'span1'),
			),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=> array('class'=>'span1'),
			),
		),
	)); 
?>