<?php
$this->pagetitle = Yii::app()->name . ' - Novo Negócio';
$this->breadcrumbs=array(
	'Negócio'=>array('index'),
	'Novo',
);

$this->menu=array(
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	array('label'=>'Listagem (F1)', 'icon'=>'icon-list-alt', 'url'=>array('index'), 'linkOptions'=> array('id'=>'btnListagem')),
);

$this->renderPartial("_hotkeys");

?>

	<div class="span4">
	</div>
<h1>Novo Negócio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'itens'=>$itens, 'codnegocioprodutobarraduplicar'=>$codnegocioprodutobarraduplicar)); ?>
