<?php
$this->pagetitle = Yii::app()->name . ' - Nova Filial';
$this->breadcrumbs=array(
	'Empresas'=>array('empresa/index'),
	$model->Empresa->empresa=>array('empresa/view', "id"=>$model->codempresa),
	'Nova',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('empresa/view', "id"=>$model->codempresa)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Filial</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>