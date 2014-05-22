<?php
$this->pagetitle = Yii::app()->name . ' - Novo CFOP';
$this->breadcrumbs=array(
	'CFOP'=>array('index'),
	'Novo CFOP',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo CFOP</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>