<?php

$total =0 ;

foreach ($model->NegocioFormaPagamentos as $nfp)
{
	?>
	<div class="registro">
		<span class="row-fluid">
			<span class="span7">
				<?php echo CHtml::encode($nfp->FormaPagamento->formapagamento) ?>
			</span>
			<span class="span4 text-right">
				<?php echo Yii::app()->format->formatNumber($nfp->valorpagamento); ?>
			</span>
			<span class="span1 text-right">
				<?php if ($model->codnegociostatus == 1 && !$nfp->FormaPagamento->lio && !$nfp->FormaPagamento->pix): ?>
					<div class="pull-right">
						<a class="delete-pagamento" href="<?php echo Yii::app()->createUrl('negocioFormaPagamento/delete', array('id'=>$nfp->codnegocioformapagamento, 'ajax'=>'ajax')); ?>"><i class="icon-trash"></i></a>
					</div>
				<?php endif; ?>
			</span>
		</span>
	</div>
	<?
	$total += $nfp->valorpagamento;
}

?>
<span class="row-fluid">
	<b class="span7">
		Total
	</b>
	<b class="span4 text-right">
		<?php echo Yii::app()->format->formatNumber($total ); ?>
		<input type="hidden" value ="<?php echo $total ?>" id="totalvalorpagamento">
	</b>
</span>
