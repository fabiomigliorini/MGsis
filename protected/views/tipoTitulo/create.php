<?php
$this->pagetitle = Yii::app()->name . ' - Novo Tipo Título';
$this->breadcrumbs=array(
	'Tipo Título'=>array('index'),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Tipo Título</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>