<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Titulo';
$this->breadcrumbs=array(
	'Titulo'=>array('index'),
	$model->codtitulo,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtitulo)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('titulo/delete', array('id' => $model->codtitulo))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codtitulo; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
			'codtitulo',
		'codtipotitulo',
		'codfilial',
		'codportador',
		'codpessoa',
		'codcontacontabil',
		'numero',
		'fatura',
		'transacao',
		'sistema',
		'emissao',
		'vencimento',
		'vencimentooriginal',
		'debito',
		'credito',
		'gerencial',
		'observacao',
		'boleto',
		'nossonumero',
		'debitototal',
		'creditototal',
		'saldo',
		'debitosaldo',
		'creditosaldo',
		'transacaoliquidacao',
		'codnegocioformapagamento',
		'codtituloagrupamento',
		'remessa',
		'estornado',
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
