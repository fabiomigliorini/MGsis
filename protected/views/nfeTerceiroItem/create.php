<?php
$this->pagetitle = Yii::app()->name . ' - Novo Nfe Terceiro Item';
$this->breadcrumbs=array(
	'Nfe Terceiro Item'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo NfeTerceiroItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>