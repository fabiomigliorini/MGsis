<?php
if (!isset($pe))
{
	$sigla = $data->UnidadeMedida->sigla; 
	$preco = $data->preco;
	$condition = 'codprodutoembalagem IS NULL';
	$params = array();
}
else
{
	$sigla = $pe->UnidadeMedida->sigla . " C/" . Yii::app()->format->formatNumber($pe->quantidade, 0);
	$preco = empty($pe->preco)?$data->preco * $pe->quantidade:$pe->preco;
	$condition = 'codprodutoembalagem = :cod';
	$params = array(':cod'=>$pe->codprodutoembalagem);
}

?>
<div class="row-fluid subregistro">
	<b class="span2 text-right">
		<?php echo CHtml::encode(Yii::app()->format->formatNumber($preco)); ?>
	</b>
	<small class="span2">
		<?php echo CHtml::encode($sigla); ?>
	</small>
	<?php foreach ($data->ProdutoBarras(array('condition'=>$condition, 'params'=>$params)) as $pb): ?>
		<small class="span8 pull-right muted"> 
			<div class="span3">
				<?php echo CHtml::encode($pb->barras); ?>
			</div>
			<div class="span5">
				<?php echo CHtml::encode($pb->variacao); ?>
			</div>
			<div class="span4">
				<b><?php echo CHtml::encode((!empty($pb->codmarca))?$pb->Marca->marca:""); ?></b>
				<?php echo CHtml::encode($pb->referencia); ?>
			</div>
		</small>
	<?php endforeach; ?>
</div>
