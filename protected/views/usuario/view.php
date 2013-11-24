<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->pagetitle = Yii::app()->name . ' - Usuario #' . $model->codusuario;


$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario,
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Alterar', 'url'=>array('update', 'id'=>$model->codusuario)),
	array('label'=>'Excluir', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codusuario),'confirm'=>'Tem certeza que deseja excluir este registro?')),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Usuario #<?php echo $model->codusuario; ?></h1>

<?php 
$this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
		'data'=>$model,
		'attributes'=>array(
			'codusuario',
			'usuario',
			'senha',
			array(
				'name'=>'codecf',
				'value'=>isset($model->codecf)?CHtml::encode($model->Ecf->ecf):Null,
				),
			array(
				'name'=>'codfilial',
				'value'=>isset($model->codfilial)?CHtml::encode($model->Filial->filial):Null,
				),
			array(
				'name'=>'codoperacao',
				'value'=>isset($model->codoperacao)?CHtml::encode($model->Operacao->operacao):Null,
				),
			array(
				'name'=>'codpessoa',
				'value'=>isset($model->codpessoa)?CHtml::encode($model->Pessoa->fantasia):Null,
				),
			'impressoratelanegocio',
			array(
				'name'=>'codportador',
				'value'=>isset($model->codportador)?CHtml::encode($model->Portador->portador):Null,
				),
			'alteracao',
			array(
				'name'=>'codusuarioalteracao',
				'value'=>isset($model->codusuarioalteracao)?CHtml::encode($model->UsuarioAlteracao->usuario):Null,
				),
			'criacao',
			array(
				'name'=>'codusuariocriacao',
				'value'=>isset($model->codusuariocriacao)?CHtml::encode($model->UsuarioCriacao->usuario):Null,
				),
			),
		)
	);
/*
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'codusuario',
		'usuario',
		'senha',
		array(
			'name'=>'codecf',
			'value'=>isset($model->codecf)?CHtml::encode($model->Ecf->ecf):Null,
		),
		array(
			'name'=>'codfilial',
			'value'=>isset($model->codfilial)?CHtml::encode($model->Filial->filial):Null,
		),
		array(
			'name'=>'codoperacao',
			'value'=>isset($model->codoperacao)?CHtml::encode($model->Operacao->operacao):Null,
		),
		array(
			'name'=>'codpessoa',
			'value'=>isset($model->codpessoa)?CHtml::encode($model->Pessoa->fantasia):Null,
		),
		'impressoratelanegocio',
		array(
			'name'=>'codportador',
			'value'=>isset($model->codportador)?CHtml::encode($model->Portador->portador):Null,
		),
		'alteracao',
		array(
			'name'=>'codusuarioalteracao',
			'value'=>isset($model->codusuarioalteracao)?CHtml::encode($model->UsuarioAlteracao->usuario):Null,
		),
		'criacao',
		array(
			'name'=>'codusuariocriacao',
			'value'=>isset($model->codusuariocriacao)?CHtml::encode($model->UsuarioCriacao->usuario):Null,
		),
	),
));
 * 
 */
?>
