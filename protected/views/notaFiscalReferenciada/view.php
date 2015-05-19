<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal Referenciada';

$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	Yii::app()->format->formataChaveNfe($model->nfechave)
);


$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view','id'=>$model->codnotafiscal)),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscalreferenciada)),
array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
//array('label'=>'Gerenciar', 'icon'=>'icon-briefcase', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerCoreScript('yii');

?>
<script type="text/javascript">
/*<![CDATA[*/
$(document).ready(function(){
	jQuery('body').on('click','#btnExcluir',function() {
		bootbox.confirm("Excluir este registro?", function(result) {
			if (result)
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nota-fiscal-referenciada/delete', array('id' => $model->codnotafiscalreferenciada))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave)); ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codnotafiscalreferenciada',
		array(
			'name' => 'nfechave',
			'value' => str_replace(" ", "&nbsp;", CHtml::encode(Yii::app()->format->formataChaveNfe($model->nfechave))),
			'type' => 'raw',
		),
		'codnotafiscal',
		),
	)); 



	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
