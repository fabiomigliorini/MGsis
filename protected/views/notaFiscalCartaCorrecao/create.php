<?php
$this->pagetitle = Yii::app()->name . ' - Nova Carta de Correção da Nota Fiscal';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	'Nova Carta de Correção',
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
	//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);
?>

<h1>Nova Carta de Correção da Nota Fiscal</h1>


<?php if ((!empty($erroMonitor)) || (!empty($retorno))): ?>
<div class="alert alert-error">
  <h4>Erro ao criar Carta de Correção:</h4> 
  <?php echo $erroMonitor; ?>
  <br>
  <?php echo $retorno; ?>
</div>
<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>