<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Codigos';
$this->breadcrumbs=array(
	'Codigos'=>array('index'),
	$model->tabela,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->tabela)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tabela),'confirm'=>'Tem Certeza que deseja excluir este item?')),
array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Detalhes Codigo #<?php echo $model->tabela; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'tabela',
		'codproximo',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
