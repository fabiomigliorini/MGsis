<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Negocio Produto Barra';
$this->breadcrumbs=array(
	'Negocios'=>array('negocio/index'),
	$model->codnegocio=>array('negocio/view','id'=>$model->codnegocio),
	$model->ProdutoBarra->descricao=>array('produto/view','id'=>$model->ProdutoBarra->codproduto),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('negocio/view','id'=>$model->codnegocio)),
	//array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	//array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnegocioprodutobarra)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Item <?php echo CHtml::encode($model->ProdutoBarra->descricao); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>