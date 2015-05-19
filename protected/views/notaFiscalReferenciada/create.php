<?php
$this->pagetitle = Yii::app()->name . ' - Novo Nota Fiscal Referenciada';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	'Nova Nota Fiscal Referenciada'
);


$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('NotaFiscal/view', 'id'=>$model->codnotafiscal)),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Nota Fiscal Referenciada</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>