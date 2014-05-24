<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal Duplicatas';
$this->breadcrumbs=array(
	'Nota Fiscal Duplicatas'=>array('index'),
	$model->codnotafiscalduplicatas,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscalduplicatas)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('nota-fiscal-duplicatas/delete', array('id' => $model->codnotafiscalduplicatas))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codnotafiscalduplicatas; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codnotafiscalduplicatas',
		'codnotafiscal',
		'fatura',
		'vencimento',
		'valor',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
