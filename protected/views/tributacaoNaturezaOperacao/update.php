<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Tributação Natureza Operação';
$this->breadcrumbs=array(
	'Natureza Operação'=>array('naturezaOperacao/index'),
	$model->NaturezaOperacao->naturezaoperacao=>array('naturezaOperacao/view', "id"=>$model->codnaturezaoperacao),
	$model->codtributacaonaturezaoperacao=>array('view','id'=>$model->codtributacaonaturezaoperacao),
	'Alterar',
);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('naturezaOperacao/view', 'id'=>$model->codnaturezaoperacao)),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', "codnaturezaoperacao"=>$model->codnaturezaoperacao)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtributacaonaturezaoperacao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Tributação Natureza Operação <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtributacaonaturezaoperacao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>