<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Tributação Natureza Operação';
$this->breadcrumbs=array(
	'Tributação Natureza Operação'=>array('index'),
	$model->codtributacaonaturezaoperacao,
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Nova', 'icon'=>'icon-plus', 'url'=>array('create')),
array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtributacaonaturezaoperacao)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('tributacaoNaturezaOperacao/delete', array('id' => $model->codtributacaonaturezaoperacao))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1><?php echo $model->codtributacaonaturezaoperacao; ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codtributacaonaturezaoperacao',
		//'codtributacao',
		array(
					'name'=>'codtributacao',
					'value'=>(isset($model->Tributacao))?CHtml::link(CHtml::encode($model->Tributacao->tributacao),array('tributacao/view','id'=>$model->codtributacao)):null,
					'type'=>'raw',
					),
		//'codnaturezaoperacao',
		array(
					'name'=>'codnaturezaoperacao',
					'value'=>(isset($model->NaturezaOperacao))?CHtml::link(CHtml::encode($model->NaturezaOperacao->naturezaoperacao),array('naturezaOperacao/view','id'=>$model->codnaturezaoperacao)):null,
					'type'=>'raw',
					),
		//'codcfop',
		array(
					'name'=>'codcfop',
					'value'=>(isset($model->Cfop))?CHtml::link(CHtml::encode($model->Cfop->cfop),array('cfop/view','id'=>$model->codcfop)):null,
					'type'=>'raw',
					),
		'icmsbase',
		'icmspercentual',
		//'codestado',
		array(
					'name'=>'codestado',
					'value'=>(isset($model->Estado))?CHtml::link(CHtml::encode($model->Estado->estado),array('estado/view','id'=>$model->codestado)):null,
					'type'=>'raw',
					),
		'icmsbase',
		'csosn',
		//'codtipoproduto',
		array(
					'name'=>'codtipoproduto',
					'value'=>(isset($model->TipoProduto))?CHtml::link(CHtml::encode($model->TipoProduto->tipoproduto),array('tipoProduto/view','id'=>$model->codtipoproduto)):null,
					'type'=>'raw',
					),
		'acumuladordominiovista',
		'acumuladordominioprazo',
		'historicodominio',
		//'movimentacaofisica',
		array(
			'name'=>'movimentacaofisica',
			'value'=>($model->movimentacaofisica)?'Sim':'Não',
			),
		//'movimentacaocontabil',
		array(
			'name'=>'movimentacaocontabil',
			'value'=>($model->movimentacaocontabil)?'Sim':'Não',
			),
		),
	)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
