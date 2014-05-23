<?php
$this->pagetitle = Yii::app()->name . ' - Nova Empresa';
$this->breadcrumbs=array(
	'Empresas'=>array('index'),
	'Nova Empresa',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Empresa</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>