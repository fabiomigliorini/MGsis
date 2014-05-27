<?php
$this->pagetitle = Yii::app()->name . ' - Novo Cidade';
$this->breadcrumbs=array(
	'Cidade'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Cidade</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>