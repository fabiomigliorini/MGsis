<?php
$this->pagetitle = Yii::app()->name . ' - Novo Tipo Movimento Título';
$this->breadcrumbs=array(
	'Tipo Movimento Título'=>array('index'),
	'Novo Tipo Movimento Título',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Tipo Movimento Título</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>