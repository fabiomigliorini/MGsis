<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal Referenciada';

$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	Yii::app()->format->formataChaveNfe($model->nfechave)=>array('notaFiscalReferenciada/view','id'=>$model->codnotafiscalreferenciada),
	'Alterar',
);



$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view','id'=>$model->codnotafiscal)),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
	array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscalreferenciada)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

	<h1>Alterar Nota Fiscal Referenciada <?php echo CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave)); ?></h1>
	<br>

	<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
	<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>