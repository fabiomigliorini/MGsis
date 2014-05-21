<?php
$this->pagetitle = Yii::app()->name . ' - Nova Tributação';
$this->breadcrumbs=array(
	'Tributações'=>array('index'),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Tributação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>