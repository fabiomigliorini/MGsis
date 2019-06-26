<?php
$this->pagetitle = Yii::app()->name . ' - Nova Tributação da Natureza de Operacao';
$this->breadcrumbs=array(
	'Naurezas de Operação'=>array('naturezaOperacao/index'),
	$model->NaturezaOperacao->naturezaoperacao=>array('naturezaOperacao/view', "id"=>$model->codnaturezaoperacao),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('naturezaOperacao/view', 'id'=>$model->codnaturezaoperacao)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Tributação da Natureza de Operação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>