<?php
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	'Novo Pagamento',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
);

?>

<h1>Novo Pagamento</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>