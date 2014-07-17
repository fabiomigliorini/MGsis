<?php
$this->pagetitle = Yii::app()->name . ' - Novo Nfe Terceiro Duplicata';
$this->breadcrumbs=array(
	'Nfe Terceiro Duplicata'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo NfeTerceiroDuplicata</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>