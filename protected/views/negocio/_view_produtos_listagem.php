<?php

foreach ($model->NegocioProdutoBarras as $npb)
{
	?>
	<div class="registro">
		<span class="row-fluid">
			<small class="span2 muted">
				<?php echo CHtml::encode($npb->ProdutoBarra->barras) ?> 
			</small>
			<span class="span5">
				<?php echo CHtml::link(CHtml::encode($npb->ProdutoBarra->descricao), array('produto/view', 'id'=> $npb->ProdutoBarra->codproduto)); ?> 
			</span>
			<span class="span2 text-right">
				<?php echo Yii::app()->format->formatNumber($npb->quantidade); ?>  &nbsp;
				<small class="pull-right muted">
					<?php echo CHtml::encode($npb->ProdutoBarra->UnidadeMedida->sigla); ?> 
				</small>
			</span>
			<span class="span1 text-right muted">
				<?php echo Yii::app()->format->formatNumber($npb->valorunitario); ?> 
			</span>
			<b class="span2 text-right">
				<?php echo Yii::app()->format->formatNumber($npb->valortotal); ?> 
				&nbsp;
				<?php if ($model->codnegociostatus == 1): ?>
					<div class="pull-right">
						<a href="<?php echo Yii::app()->createUrl('negocioProdutoBarra/update', array('id'=>$npb->codnegocioprodutobarra)); ?>"><i class="icon-pencil"></i></a>
						<a class="delete-barra" href="<?php echo Yii::app()->createUrl('negocioProdutoBarra/delete', array('id'=>$npb->codnegocioprodutobarra)); ?>"><i class="icon-trash"></i></a>
					</div>
				<?php endif; ?>
			</b>
		</span>
	</div>

	<?
}

?>