<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes do Cheque';
$this->breadcrumbs=array(
	'Cheque'=>array('index'),
	$model->emitente,
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

<h1><?php echo $model->emitente; ?></h1>

<?php 

$css_label = "";

switch ($model->codstatus)
{
	case Cheque::CODSTATUS_ABERTO;
		$css_label = "label-success";
		break;

	case Cheque::CODSTATUS_REPASSADO;
		$css_label = "label-info";
		break;

	case Cheque::CODSTATUS_DEVOLVIDO;
		$css_label = "label-important";
		break;

	case Cheque::CODSTATUS_CANCELADO;
		break;
	
}

$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codcheque',
		'cmc7',
		//'codbanco',
		array(
			'name'=>'codbanco',
			'value'=>(isset($model->codbanco))?CHtml::link(CHtml::encode($model->Banco->banco),array('banco/view','id'=>$model->codbanco)):null,
			'type'=>'raw',
			),
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
		//'status',
		array(
			'label'=>'Status',
			'value'=>"<small class='label $css_label'>$model->status</small>",
			'type'=>'raw',
		),
		//'observacao',
		array(
			'name'=>'observacao',
			'value'=>nl2br(CHtml::encode($model->observacao)),
			'type'=>'raw',
			),
		'lancamento',
		'cancelamento',
		//'valor',
		array(
				'name'=>'valor',
				'value'=>Yii::app()->format->formatNumber($model->valor) . " ",
				),
		
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
