<?php
$this->pagetitle = Yii::app()->name . ' - Nova Cidade';
$this->breadcrumbs=array(
	'Países'=>array('pais/index'),
	$model->Estado->Pais->pais=>array('pais/view', "id"=>$model->Estado->codpais),
	$model->Estado->estado=>array('estado/view', "id"=>$model->codestado),

	'Nova Cidade',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('estado/view', "id"=>$model->codestado)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Cidade</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>