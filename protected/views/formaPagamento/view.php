<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Forma Pagamento';
$this->breadcrumbs=array(
	'Forma Pagamento'=>array('index'),
	$model->codformapagamento,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codformapagamento)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('forma-pagamento/delete', array('id' => $model->codformapagamento))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codformapagamento; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codformapagamento',
		'formapagamento',
		//'boleto',
		array(
			'name'=>'boleto',
			'value'=>($model->boleto)?'Sim':'Não',
			),
		//'fechamento',
		array(
			'name'=>'fechamento',
			'value'=>($model->fechamento)?'Sim':'Não',
			),
		//'notafiscal',
		array(
			'name'=>'nota Fiscal',
			'value'=>($model->notafiscal)?'Sim':'Não',
			),
		'parcelas',
		'diasentreparcelas',
		//'avista',
		array(
			'name'=>'avista',
			'value'=>($model->avista)?'Sim':'Não',
			),
		'formapagamentoecf',
		//'entrega',
		array(
			'name'=>'entrega',
			'value'=>($model->entrega)?'Sim':'Não',
			),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
