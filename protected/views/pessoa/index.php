<?php
$this->pagetitle = Yii::app()->name . ' - Pessoa';
$this->breadcrumbs=array(
	'Pessoa',
);

$this->menu=array(
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
?>

<h1>Pessoa</h1>

<?php 
$this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'itemsTagName'=>'table',
	'template'=>'{pager} {sorter} {items} {pager}',
	)); 
?>
