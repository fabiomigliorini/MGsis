<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes da Cidade';
$this->breadcrumbs=array(
	'Cidade'=>array('index'),
	$model->cidade,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcidade)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->codcidade),'confirm'=>'Tem Certeza que deseja excluir este item?')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Detalhes da Cidade #<?php echo $model->codcidade; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codcidade',
		//'codestado',
		array(
					'name'=>'codestado',
					'value'=>(isset($model->codestado))?CHtml::link(CHtml::encode($model->Estado->estado),array('estado/view','id'=>$model->codestado)):null,
					'type'=>'raw',
					),
		'cidade',
		'sigla',
		'codigooficial',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
