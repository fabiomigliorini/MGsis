<?php
$this->pagetitle = Yii::app()->name . ' - Novo Tributacao Natureza Operacao';
$this->breadcrumbs=array(
	'Naureza Operação'=>array('naturezaOperacao/index'),
	$model->NaturezaOperacao->naturezaoperacao=>array('naturezaOperacao/view', "id"=>$model->codnaturezaoperacao),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('naturezaOperacao/view', 'id'=>$model->codnaturezaoperacao)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Tributação Natureza Operação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>