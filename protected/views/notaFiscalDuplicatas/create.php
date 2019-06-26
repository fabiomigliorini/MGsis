<?php
$this->pagetitle = Yii::app()->name . ' - Nova Duplicata da Nota Fiscal';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	'Nova Duplicata',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Duplicata da Nota Fiscal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>