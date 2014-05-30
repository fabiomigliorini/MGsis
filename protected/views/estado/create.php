<?php
$this->pagetitle = Yii::app()->name . ' - Novo Estado';
$this->breadcrumbs=array(
	'Países'=>array('pais/index'),
	$model->Pais->pais=>array('pais/view', "id"=>$model->codpais),
	'Novo Estado',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pais/view', "id"=>$model->codpais)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1><?php echo CHtml::encode($model->Pais->pais); ?> - Novo Estado</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>