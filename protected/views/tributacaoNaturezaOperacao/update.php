<?php
$titulo =$model->NaturezaOperacao->naturezaoperacao 
		. " / "
		. $model->Tributacao->tributacao 
		. " / " 
		. $model->TipoProduto->tipoproduto 
		. " / " ;

if (empty($model->codestado))
	$titulo .= "Demais Estados";
else
	$titulo .= $model->Estado->sigla;
$this->pagetitle = Yii::app()->name . ' - Detalhes Tributação Natureza Operação';
$this->breadcrumbs=array(
	'Natureza Operação'=>array('naturezaOperacao/index'),
	$model->NaturezaOperacao->naturezaoperacao=>array('naturezaOperacao/view', "id"=>$model->codnaturezaoperacao),
	$titulo=>array('view','id'=>$model->codtributacaonaturezaoperacao),
	'Alterar'
	);

	$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('naturezaOperacao/view', 'id'=>$model->codnaturezaoperacao)),
	array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create', "codnaturezaoperacao"=>$model->codnaturezaoperacao)),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codtributacaonaturezaoperacao)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
	);
	?>

	<h1>Alterar Tributação da Natureza de Operação <?php echo CHtml::encode(Yii::app()->format->formataCodigo($model->codtributacaonaturezaoperacao)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>