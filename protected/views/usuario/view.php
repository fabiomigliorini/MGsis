<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Usuario';
$this->breadcrumbs=array(
	'Usuario'=>array('index'),
	$model->codusuario,
);

$this->menu=array(
array('label'=>'Lista', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codusuario)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codusuario),'confirm'=>'Tem Certeza que deseja excluir este item?')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Detalhes Usuario #<?php echo $model->codusuario; ?></h1>

<?php 

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'usuario',
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
		'ultimoacesso',
		'inativo',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>