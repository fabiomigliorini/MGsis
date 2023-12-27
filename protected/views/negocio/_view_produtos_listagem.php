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
				<?php
					foreach ($npb->NegocioProdutoBarraDevolucaos as $npb_devolucao)
					{
						if ($npb_devolucao->Negocio->codnegociostatus == NegocioStatus::FECHADO)
						{
							?>
								<div class="label label-warning">
									Devolvido <?php echo Yii::app()->format->formatNumber($npb_devolucao->quantidade, 3); ?>
									em
									<?php echo CHtml::link(Yii::app()->format->formataCodigo($npb_devolucao->codnegocio), array('view', 'id'=>$npb_devolucao->codnegocio)); ?>
								</div>
							<?php
						}
					}

					if (!empty($npb->codnegocioprodutobarradevolucao))
					{
						?>
							<div class="label label-warning">
								Devolução referente Negócio
								<?php echo CHtml::link(Yii::app()->format->formataCodigo($npb->NegocioProdutoBarraDevolucao->codnegocio), array('view', 'id'=>$npb->NegocioProdutoBarraDevolucao->codnegocio)); ?>
							</div>
						<?php
					}

				?>
			</span>
			<span class="span2 text-right">
				<?php echo Yii::app()->format->formatNumber($npb->quantidade, 3); ?>  &nbsp;
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
				<?php if ($model->podeEditar()): ?>
					<div class="pull-right">
						<a href="<?php echo Yii::app()->createUrl('negocioProdutoBarra/update', array('id'=>$npb->codnegocioprodutobarra)); ?>"><i class="icon-pencil"></i></a>
						<a class="delete-barra" href="<?php echo Yii::app()->createUrl('negocioProdutoBarra/delete', array('id'=>$npb->codnegocioprodutobarra, 'ajax'=>'ajax')); ?>"><i class="icon-trash"></i></a>
					</div>
				<?php endif; ?>
			</b>
		</span>
		<?php

		?>
	</div>

	<?
}

?>