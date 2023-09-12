<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Negócio Fechado';
$this->breadcrumbs=array(
	'Negócio'=>array('index'),
	$model->codnegocio=>array('view','id'=>$model->codnegocio),
	'Alterar Negócio Fechado',
);

$this->menu=array(
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array('label'=>'Listagem (F1)', 'icon'=>'icon-list-alt', 'url'=>array('index'), 'linkOptions'=> array('id'=>'btnListagem')),
);

// $this->renderPartial("_hotkeys");

?>

	<div class="span4">
	</div>
<h1>Alterar Negócio Fechado</h1>

<?php echo $this->renderPartial('_formalterar', array('model'=>$model, 'itens'=>$itens)); ?>
