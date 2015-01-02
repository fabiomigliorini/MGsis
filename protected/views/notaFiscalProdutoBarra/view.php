<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Nota Fiscal Produto Barra';
$this->breadcrumbs=array(
	'Notas Fiscais'=>array('notaFiscal/index'),
	Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo)=>array('notaFiscal/view','id'=>$model->codnotafiscal),
	$model->ProdutoBarra->descricao
);

$this->menu=array(
	array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('notaFiscal/view', 'id'=>$model->codnotafiscal)),
	array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create', 'codnotafiscal'=>$model->codnotafiscal)),
	array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codnotafiscalprodutobarra)),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('notaFiscalProdutoBarra/delete', array('id' => $model->codnotafiscalprodutobarra))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>
	<?php echo Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo) ?>
	&nbsp;-&nbsp;
	<?php echo CHtml::encode($model->ProdutoBarra->descricao) ?>
</h1>

<?php 
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'codnotafiscalprodutobarra',
		array(
			'name' => 'codnotafiscal',
			'value' => CHtml::link(Yii::app()->format->formataNumeroNota($model->NotaFiscal->emitida, $model->NotaFiscal->serie, $model->NotaFiscal->numero, $model->NotaFiscal->modelo), array('notaFiscal/view','id'=>$model->codnotafiscal)),
			'type' => 'raw'
		),
		array(
			'label' => 'Barras',
			'value' => CHtml::encode($model->ProdutoBarra->barras),
			'type' => 'raw',
		),
		array(
			'name' => 'codprodutobarra',
			'value' => CHtml::link(CHtml::encode($model->ProdutoBarra->descricao), array("produto/view", "id"=>$model->ProdutoBarra->codproduto)),
			'type' => 'raw',
		),
		'descricaoalternativa',
		array(
			'label' => 'NCM',
			'value' => CHtml::encode(Yii::app()->format->formataNcm($model->ProdutoBarra->Produto->ncm)),
			'type' => 'raw',
		),
		array (
			'name' => 'quantidade',
			'value' => CHtml::encode(Yii::app()->format->formatNumber($model->quantidade)),
			'type' => 'raw',
		),
		array (
			'label' => 'Unidade de Medida',
			'value' => CHtml::encode($model->ProdutoBarra->UnidadeMedida->sigla),
			'type' => 'raw',
		),
		array (
			'name' => 'valorunitario',
			'value' => CHtml::encode(Yii::app()->format->formatNumber($model->valorunitario)),
			'type' => 'raw',
		),
		array (
			'name' => 'valortotal',
			'value' => CHtml::encode(Yii::app()->format->formatNumber($model->valortotal)),
			'type' => 'raw',
		),
		array (
			'name' => 'codcfop',
			'value' => CHtml::link(CHtml::encode($model->codcfop . ' - ' . $model->Cfop->cfop), array("cfop/view", "id"=>$model->codcfop)),
			'type' => 'raw',
		),
		array (
			'label' => 'ICMS',
			'value' => 
				CHtml::encode(
					'(' . $model->csosn . $model->icmscst . ')' .
					' - ' . 
					Yii::app()->format->formatNumber($model->icmsbase) . ' * ' .
					Yii::app()->format->formatNumber($model->icmspercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->icmsvalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'ICMS ST',
			'value' => 
				CHtml::encode(
					Yii::app()->format->formatNumber($model->icmsstbase) . ' * ' .
					Yii::app()->format->formatNumber($model->icmsstpercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->icmsstvalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'IPI',
			'value' => 
				CHtml::encode(
					'(' . $model->ipicst . ')' .
					' - ' . 
					Yii::app()->format->formatNumber($model->ipibase) . ' * ' .
					Yii::app()->format->formatNumber($model->ipipercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->ipivalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'PIS',
			'value' => 
				CHtml::encode(
					'(' . $model->piscst . ')' .
					' - ' . 
					Yii::app()->format->formatNumber($model->pisbase) . ' * ' .
					Yii::app()->format->formatNumber($model->pispercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->pisvalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'Cofins',
			'value' => 
				CHtml::encode(
					'(' . $model->cofinscst . ')' .
					' - ' . 
					Yii::app()->format->formatNumber($model->cofinsbase) . ' * ' .
					Yii::app()->format->formatNumber($model->cofinspercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->cofinsvalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'CSLL',
			'value' => 
				CHtml::encode(
					Yii::app()->format->formatNumber($model->csllbase) . ' * ' .
					Yii::app()->format->formatNumber($model->csllpercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->csllvalor) 
				),
			'type' => 'raw',
		),
		array (
			'label' => 'IRPJ',
			'value' => 
				CHtml::encode(
					Yii::app()->format->formatNumber($model->irpjbase) . ' * ' .
					Yii::app()->format->formatNumber($model->irpjpercentual) . '% = ' .
					Yii::app()->format->formatNumber($model->irpjvalor) 
				),
			'type' => 'raw',
		),
		array(
			'name' => 'codnegocioprodutobarra',
			'value' => isset($model->NegocioProdutoBarra)?CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($model->NegocioProdutoBarra->codnegocio)), array("negocio/view", "id"=>$model->NegocioProdutoBarra->codnegocio)):'',
			'type' => 'raw',
		),
	),
)); 

	$this->widget('UsuarioCriacao', array('model'=>$model));

?>
