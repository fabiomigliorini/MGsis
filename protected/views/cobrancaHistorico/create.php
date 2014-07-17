<?php
$this->pagetitle = Yii::app()->name . ' - Novo Histórico de Cobrança';
$this->breadcrumbs=array(
	'Pessoas'=>array('pessoa/index'),
	$model->Pessoa->pessoa=>array('pessoa/view', "id"=>$model->codpessoa),
	'Histórico Cobrança'=>array('pessoa/view', "id"=>$model->codpessoa),
	'Novo',
);

$this->menu=array(
//array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('pessoa/view', 'id'=>$model->codpessoa)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Histórico de Cobrança</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>