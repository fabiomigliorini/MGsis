<?php
$this->pagetitle = Yii::app()->name . ' - Detalhes Agrupamento de Títulos';
$this->breadcrumbs=array(
	'Agrupamento de Títulos'=>array('index'),
	Yii::app()->format->formataCodigo($model->codtituloagrupamento),
);

$this->menu=array(
array('label'=>'Listagem', 'icon'=>'icon-list-alt', 'url'=>array('index')),
array('label'=>'Novo', 'icon'=>'icon-plus', 'url'=>array('create')),
//array('label'=>'Alterar', 'icon'=>'icon-pencil', 'url'=>array('update','id'=>$model->codtituloagrupamento)),
//array('label'=>'Excluir', 'icon'=>'icon-trash', 'url'=>'#', 'linkOptions'=>	array('id'=>'btnExcluir')),
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
				jQuery.yii.submitForm(document.body.childNodes[0], "<?php echo Yii::app()->createUrl('titulo-agrupamento/delete', array('id' => $model->codtituloagrupamento))?>",{});
		});
	});
});
/*]]>*/
</script>

<h1>Agrupamento de Títulos <?php echo Yii::app()->format->formataCodigo($model->codtituloagrupamento); ?></h1>

<?php 

$total = $model->calculaTotal();
$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'emissao',
		'cancelamento',
		'observacao',
		array(
			'label'=>'Total',
			'value'=>Yii::app()->format->formatNumber($total) . " " . (($total<0)?"CR":"DB"),
		),
	),
)); 

$this->widget('UsuarioCriacao', array('model'=>$model));
?>

<h2>Títulos Gerados</h2>

<?php

foreach ($model->Titulos as $titulo)
{
	$css_valor = ($titulo->operacao == "DB")?"text-success":"text-warning";	
	?>
	<div class="registro">
		<small class="row-fluid">
			<span class="span1 <?php echo ($titulo->gerencial)?"text-warning":"text-success"; ?>">
				<?php echo CHtml::encode($titulo->Filial->filial); ?> 
			</span>
			<span class="span2 muted">
				<?php echo CHtml::link(CHtml::encode($titulo->numero),array('titulo/view','id'=>$titulo->codtitulo)); ?> 
			</span>
			<b class="span2 text-right <?php echo $css_valor; ?>">
				<?php echo Yii::app()->format->formatNumber($titulo->valor); ?>
				<?php echo $titulo->operacao; ?>
			</b>
			<b class="span1">
				<?php echo $titulo->vencimento; ?>
			</b>
			<span class="span3 muted">
				<?php echo CHtml::link($titulo->Pessoa->fantasia,array('pessoa/view','id'=>$titulo->codpessoa)); ?> 
			</span>
			<span class="span1">
				<?php echo (isset($titulo->Portador))?CHtml::encode($titulo->Portador->portador):""; ?>
			</span>
			<span class="span2">
				<?php echo ($titulo->boleto)?"Boleto " . CHtml::encode($titulo->nossonumero):""; ?>
			</span>
		</small>
	</div>
	<?
}

unset($titulo)
?>

<h2>Títulos Baixados</h2>

<?php

foreach ($model->MovimentoTitulos as $mov)
{
	if ($mov->Titulo->codtituloagrupamento == $model->codtituloagrupamento)
		continue;
	$css_valor = ($mov->Titulo->operacao == "DB")?"text-success":"text-warning";	
	?>
	<div class="registro">
		<small class="row-fluid">
			<span class="span1 <?php echo ($mov->Titulo->gerencial)?"text-warning":"text-success"; ?>">
				<?php echo CHtml::encode($mov->Titulo->Filial->filial); ?> 
			</span>
			<span class="span2 muted">
				<?php echo CHtml::link(CHtml::encode($mov->Titulo->numero),array('titulo/view','id'=>$mov->Titulo->codtitulo)); ?> 
			</span>
			<b class="span2 text-right <?php echo $css_valor; ?>">
				<?php echo Yii::app()->format->formatNumber(abs($mov->debito-$mov->credito)); ?>
				<?php echo $mov->Titulo->operacao; ?>
			</b>
			<b class="span1">
				<?php echo $mov->Titulo->vencimento; ?>
			</b>
			<span class="span3 muted">
				<?php echo CHtml::link(CHtml::encode($mov->Titulo->Pessoa->fantasia),array('pessoa/view','id'=>$mov->Titulo->codpessoa)); ?> 
			</span>
			<span class="span1">
				<?php echo (isset($mov->Titulo->Portador))?CHtml::encode($mov->Titulo->Portador->portador):""; ?>
			</span>
			<span class="span2">
				<?php echo ($mov->Titulo->boleto)?"Boleto " . CHtml::encode($mov->Titulo->nossonumero):""; ?>
			</span>
		</small>
	</div>
	<?
}

?>
