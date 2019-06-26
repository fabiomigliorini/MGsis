<?php
$this->pagetitle = Yii::app()->name . ' - Novo Sub Grupos de Produtos';
$this->breadcrumbs=array(
	'Grupos de Produtos'=>array('grupoProduto/index'),
	$model->GrupoProduto->grupoproduto=>array('grupoProduto/view', "id"=>$model->codgrupoproduto),
	'Novo',
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('grupoProduto/view', "id"=>$model->codgrupoproduto)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Sub Grupos de Produtos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>