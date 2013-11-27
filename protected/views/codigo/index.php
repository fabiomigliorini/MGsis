<?php
$this->breadcrumbs=array(
	'Codigos',
);

$this->menu=array(
array('label'=>'Create Codigo','url'=>array('create')),
array('label'=>'Manage Codigo','url'=>array('admin')),
);
?>

<h1>Codigos</h1>

<hr>
--------------------------------------------------------------------------------------------
<hr>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    )); 
?>

<hr>
--------------------------------------------------------------------------------------------
<hr>
