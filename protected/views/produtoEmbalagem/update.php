<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Embalagem de Produto';
$this->breadcrumbs=array(
	'Produtos'=>array('produto/index'),
	$model->Produto->produto => array('produto/view', 'id'=>$model->codproduto),
	$model->descricao,
	'Alterar',
);

$this->menu=array(
	array('label'=>'Produto', 'icon'=>'icon-list-alt', 'url'=>array('produto/view', 'id'=>$model->codproduto)),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', 'codproduto'=>$model->codproduto)),
	//array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codprodutoembalagem)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Alterar Embalagem <?php echo CHtml::encode($model->Produto->produto . " " . $model->descricao); ?></h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>