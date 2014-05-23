<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Cheque';
$this->breadcrumbs=array(
	'Cheque'=>array('index'),
	$model->codcheque,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codcheque)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('cheque/delete', array('id' => $model->codcheque))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codcheque; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codcheque',
		'cmc7',
		'codbanco',
		'agencia',
		'contacorrente',
		'emitente',
		'numero',
		'emissao',
		'vencimento',
		'repasse',
		'destino',
		'devolucao',
		'motivodevolucao',
		'observacao',
		'lancamento',
		'cancelamento',
		'valor',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
