<?php
$this->pagetitle = Yii::app()->name . ' - Nova Conta Contábil';
$this->breadcrumbs=array(
	'Conta Contábil'=>array('index'),
	'Nova Conta Contábil',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Conta Contábil</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>