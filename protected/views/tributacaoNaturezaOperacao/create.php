<?php
$this->pagetitle = Yii::app()->name . ' - Novo Tributacao Natureza Operacao';
$this->breadcrumbs=array(
	'Tributacao Natureza Operacao'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Tributação Natureza Operação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>