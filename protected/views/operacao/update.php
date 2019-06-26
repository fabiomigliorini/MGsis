<?php
/* @var $this OperacaoController */
/* @var $model Operacao */
$this->pagetitle = Yii::app()->name . ' - Alterar Operacao #' . $model->codusuario;

$this->breadcrumbs=array(
	'Operacao'=>array('index'),
	$model->codoperacao=>array('view','id'=>$model->codoperacao),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'url'=>array('index')),
	array('label'=>'Novo', 'url'=>array('create')),
	array('label'=>'Detalhes', 'url'=>array('view', 'id'=>$model->codoperacao)),
	array('label'=>'Gerenciar', 'url'=>array('admin')),
);
?>

<h1>Alterar Operacao #<?php echo $model->codoperacao; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>