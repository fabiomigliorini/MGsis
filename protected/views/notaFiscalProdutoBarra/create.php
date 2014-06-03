<?php
$this->pagetitle = Yii::app()->name . ' - Novo Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero)=>array('view','id'=>$model->codnotafiscal),
	'Novo Produto',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Novo Produto da Nota Fiscal</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>