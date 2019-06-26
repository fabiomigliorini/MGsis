<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	$model->produto=>array('view','id'=>$model->codproduto),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codproduto)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Alterar Produto <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codproduto, 6)); ?></h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>