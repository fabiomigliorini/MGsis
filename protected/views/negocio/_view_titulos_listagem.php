<?php
/*
 * @var Titulo $titulo
 */

if (!empty($model->NegocioFormaPagamentos))
{
	/*
	?>
	<div class="alert">Nenhum Pagamento foi informado para este negócio!</div>
	<?php
	 *
	 */
	?>
	<h3>Forma de Pagamento</h3>
	<?php
}

foreach ($model->NegocioFormaPagamentos as $nfp)
{
	?>
	<div class="registro">
		<span class="row-fluid">
			<div class="span2 text-right">
				<?php echo Yii::app()->format->formatNumber($nfp->valorpagamento); ?>
			</div>
			<div class="span3">
				<b>
					<?php echo CHtml::encode($nfp->FormaPagamento->formapagamento); ?>
				</b>
				<?php if (!empty($nfp->codliopedido)):?>
					<br />
					<small class="muted">
						<abbr title="<?php echo Yii::app()->format->formataCodigo($nfp->LioPedido->codliopedido) . ' - ' . CHtml::encode($nfp->LioPedido->referencia); ?> -">
							<?php echo CHtml::encode($nfp->LioPedido->uuid); ?> <br />
						</abbr>
					</small>
				<?php endif ?>
			</div>
			<div class="span7">
				<?php
				if (!empty($nfp->codliopedido)) {
					?>
					<?php
					foreach ($nfp->LioPedido->LioPedidoPagamentos as $lpp) {
						$cssV40 = ($lpp->codigov40 == 28)?'text-error':'';
						?>
						<div class="row-fluid">
							<div class="span12">
								<b class="<?php echo $cssV40 ?>">
								<?php echo Yii::app()->format->formatNumber($lpp->valor); ?>
								-
								<?php if ($lpp->codigov40 == 28): ?>
									Cancelamento
								<?php endif ?>
								<?php echo CHtml::encode($lpp->LioBandeiraCartao->bandeiracartao); ?>
								<?php echo CHtml::encode($lpp->LioProduto->nomeprimario); ?>
								<?php echo CHtml::encode($lpp->LioProduto->nomesecundario); ?>
								-
								<?php echo CHtml::encode($lpp->nome); ?>
								</b>
								<?php
								if ($lpp->parcelas > 1) {
									?>
									(<?php echo Yii::app()->format->formatNumber($lpp->parcelas, 0); ?>
									Parcelas)
									<?php
								}
								?>
								<br />
								<b>
								</b>
								<small class="muted">
									<?php echo CHtml::encode($lpp->criacao); ?> |
									Cartão: <?php echo CHtml::encode($lpp->cartao); ?> |
									Terminal: <?php echo CHtml::encode($lpp->LioTerminal->terminal); ?> |
									Autorização: <?php echo CHtml::encode($lpp->autorizacao); ?>
									NSU: <?php echo CHtml::encode($lpp->nsu); ?>
								</small>
							</div>
						</div>

						<?php
					}
				}
				foreach ($nfp->Titulos as $titulo)
				{
					?>
					<div class="row-fluid">
						<div class="span4">
							<?php
								echo CHtml::link(
									CHtml::encode($titulo->numero)
									, array('titulo/view', 'id'=> $titulo->codtitulo));
							?>
						</div>
						<b class="span2">
							<?php echo CHtml::encode($titulo->vencimento); ?>
						</b>
						<b class="span3 text-right">
							<?php echo Yii::app()->format->formatNumber($titulo->valor); ?>
						</b>
						<div class="span3 text-right">
							<?php echo Yii::app()->format->formatNumber($titulo->saldo); ?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</span>
	</div>
	<?
}


?>
