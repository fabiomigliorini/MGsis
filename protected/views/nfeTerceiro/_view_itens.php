<?php

/**
 * @var NfeTerceiro $model
 * @var NfeTerceiroItem $item
 */

foreach ($model->NfeTerceiroItems as $item)
{
	?>
	<div class="registro">
		<small class="row-fluid">
			<div class="span1">
				<span>
					<?php echo CHtml::encode($item->cean); ?>
					<?php if ($item->cean !== $item->ceantrib) echo CHtml::encode($item->ceantrib); ?>				
				</span><br>
				<span class="muted">
					<?php echo CHtml::encode($item->cprod); ?>
				</span>
			</div>
			<div class="span3">
				<?php echo CHtml::link(CHtml::encode($item->xprod), array("nfeTerceiroItem/view", "id"=>$item->codnfeterceiroitem)); ?>
				<div class="muted">
					<?php echo CHtml::encode(Yii::app()->format->formataNcm($item->ncm)); ?>
					<?php echo CHtml::encode($item->cfop); ?>				
					<?php echo CHtml::encode($item->cst); ?>				
					<?php echo CHtml::encode($item->csosn); ?>				
				</div>
			</div>
			<div class="span4">
				<?php
				
				if (!empty($item->vsugestaovenda) && isset($item->ProdutoBarra))
				{

					$cssVenda = 'text-success';
					
					if ($item->ProdutoBarra->Produto->preco <= $item->vsugestaovenda * 0.97)
						$cssVenda = 'text-error';

					if ($item->ProdutoBarra->Produto->preco >= $item->vsugestaovenda * 1.05)
						$cssVenda = 'text-warning';
					
					?>
					<div class="span9">
						<div>
                        <b>
						<?php echo CHtml::link(CHtml::encode($item->ProdutoBarra->Produto->produto), array('produto/view', 'id'=>$item->ProdutoBarra->codproduto)); ?>
                        <BR>
                        <?php if (!empty($item->ProdutoBarra->ProdutoVariacao->variacao)): ?>
                        <?php echo $item->ProdutoBarra->ProdutoVariacao->variacao; ?>
                        <?php else: ?>
                          { Sem Variação }
                        <?php endif; ?>
                        </b>
						</div>
						<?php if (!empty($item->ProdutoBarra->Produto->inativo)): ?>
						<span class="label label-important pull-center">
							Inativado em <?php echo CHtml::encode($item->ProdutoBarra->Produto->inativo); ?>
						</span>
						
					<?php endif; ?>
					</div>
					<div class="span1">
						<?php echo CHtml::encode($item->ProdutoBarra->Produto->UnidadeMedida->sigla); ?>
					</div>
					<div class="span2 text-right">
						<b class="text-right <?php echo $cssVenda; ?>">
							<?php echo CHtml::encode(Yii::app()->format->formatNumber($item->ProdutoBarra->Produto->preco)); ?> 
						</b><br>
						<span class="text-right muted">
							(<?php echo CHtml::encode(Yii::app()->format->formatNumber($item->vsugestaovenda)); ?>)
						</span>
					</div>
					<?php
				}
				?>
			</div>
			<div class="span4 text-right">
				<div class="span2 text-right">
					<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($item->qcom, 3)); ?></b><br>
					<span class="muted"><?php echo CHtml::encode(Yii::app()->format->formatNumber($item->qtrib, 3)); ?></span>
				</div>
				<div class="span1 muted text-center">
					<span class="muted"><?php echo CHtml::encode($item->ucom); ?></span><br>
					<span class="muted"><?php echo CHtml::encode($item->utrib); ?></span>
				</div>
				<div class="span2 text-right">
					<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($item->vuncom)); ?></b><br>
					<span class="muted"><?php echo CHtml::encode(Yii::app()->format->formatNumber($item->vuntrib)); ?></span>
				</div>
				<div class="span2 text-right">
					<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($item->vprod)); ?></b>
				</div>
				<?php
				
				$imp_desc = array();
				$imp_perc = array();
				$imp_val = array();
				
				if (($item->vbc>0) || ($item->picms>0) || ($item->vicms>0))
				{
					$imp_desc[] = 'ICMS';
					$imp_perc[] = Yii::app()->format->formatNumber($item->picms, 0) . '%';
					$imp_val[] = Yii::app()->format->formatNumber($item->vicms);
				}
				if (($item->vbcst>0) || ($item->picmsst>0) || ($item->vicmsst>0))
				{
					$imp_desc[] = 'ST';
					$imp_perc[] = Yii::app()->format->formatNumber($item->picmsst, 0) . '%';
					$imp_val[] = Yii::app()->format->formatNumber($item->vicmsst);
				}
				if (($item->ipivbc>0) || ($item->ipipipi>0) || ($item->ipivipi>0))
				{
					$imp_desc[] = 'IPI';
					$imp_perc[] = Yii::app()->format->formatNumber($item->ipipipi, 0) . '%';
					$imp_val[] = Yii::app()->format->formatNumber($item->vicmsst);
				}
				?>
				<div class="span5">
					<b class="span3 text-right">
						<?php echo implode('<br>', $imp_perc); ?>
					</b>
					<div class="span3 ">
						<?php echo implode('<br>', $imp_desc); ?>
					</div>
					<div class="span6 muted text-right">
						<?php echo implode('<br>', $imp_val); ?>
					</div>
				</div>
			</div>
		</small>

	</div>
	<?php
}

?>
