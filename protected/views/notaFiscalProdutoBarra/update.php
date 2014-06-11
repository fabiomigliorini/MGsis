<?php
$this->pagetitle = Yii::app()->name . ' - Alterar Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	$model->ProdutoBarra->descricao, //=>array('view','id'=>$model->codnotafiscalprodutobarra),
	'Alterar',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codnotafiscal' => $model->codnotafiscal)),
	//array('label'=>'Detalhes', 'icon'=>'icon-eye-open', 'url'=>array('view','id'=>$model->codnotafiscalprodutobarra)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Alterar Produto da Nota Fiscal</h1>
<br>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>	
<?php $this->widget('UsuarioCriacao', array('model'=>$model)); ?>