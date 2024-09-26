<?php
$this->breadcrumbs=array(
	'Nota Fiscal Pagamentos',
);

$this->menu=array(
array('label'=>'Create NotaFiscalPagamento','url'=>array('create')),
array('label'=>'Manage NotaFiscalPagamento','url'=>array('admin')),
);
?>

<h1>Nota Fiscal Pagamentos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
