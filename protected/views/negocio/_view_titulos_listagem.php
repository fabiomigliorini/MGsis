<?php
$pagarMePedidoStatus = [
	1 => 'Pendente',
	2 => 'Pago',
	3 => 'Cancelado',
	4 => 'Falha',
];

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

				<!-- LIO -->
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
				?>
				<!-- Titulos -->
				<?php
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
				<!-- PixCob -->
				<?php
				if (!empty($nfp->codpixcob))
				{
					?>
					<div class="row-fluid">
						<div>
							<b>
								Valor Cobrança: <?php echo Yii::app()->format->formatNumber($nfp->PixCob->valororiginal); ?>
								<?php echo CHtml::encode($nfp->PixCob->PixCobStatus->pixcobstatus); ?>
							</b>
						</div>
						<div>
							<abbr title="<?php echo CHtml::encode($nfp->PixCob->location); ?>">
								<?php echo CHtml::encode($nfp->PixCob->txid); ?>
							</abbr>
						</div>
						<div>
							<?php echo CHtml::encode($nfp->PixCob->nome); ?>
						</div>
						<div>
							<?php if (!empty($nfp->PixCob->cpf)): ?>
								<?php echo Yii::app()->format->formataCnpjCpf($nfp->PixCob->cpf); ?>
							<?php endif ?>
							<?php if (!empty($nfp->PixCob->cnpj)): ?>
								<?php echo Yii::app()->format->formataCnpjCpf($nfp->PixCob->cnpj); ?>
							<?php endif ?>
						</div>
					</div>
					<?php
					foreach ($nfp->PixCob->Pixs as $pix) {
						?>
						<div class="row-fluid">
							<div>
								<b>
									Valor Pago: <?php echo Yii::app()->format->formatNumber($pix->valor); ?>
									<?php echo CHtml::encode($pix->Portador->portador); ?>
								</b>
							</div>
							<div>
								<abbr title="<?php echo CHtml::encode($pix->txid); ?>">
									<?php echo CHtml::encode($pix->e2eid); ?>
								</abbr>
							</div>
							<div>
								<?php echo CHtml::encode($pix->nome); ?>
							</div>
							<div>
								<?php if (!empty($pix->cpf)): ?>
									<?php echo Yii::app()->format->formataCnpjCpf($pix->cpf); ?>
								<?php endif ?>
								<?php if (!empty($pix->cnpj)): ?>
									<?php echo Yii::app()->format->formataCnpjCpf($pix->cnpj); ?>
								<?php endif ?>
							</div>
						</div>
						<?php
					}
				}
				?>
				<!-- Stone -->
				<?php
				if (!empty($nfp->codstonetransacao))
				{
					?>
					<div class="row-fluid">
						<div>
							<b>
								<?php echo CHtml::encode($nfp->StoneTransacao->pagador); ?> |
                                <?php echo CHtml::encode($nfp->StoneTransacao->StoneBandeira->bandeira); ?>
                                <?php if ($nfp->StoneTransacao->tipo == 1): ?>
                                    Débito
                                <?php elseif ($nfp->StoneTransacao->tipo == 2): ?>
                                    Crédito
                                <?php else: ?>
                                    Tipo <?php echo CHtml::encode($nfp->StoneTransacao->tipo); ?>
                                <?php endif; ?>
                                 |
								<?php echo CHtml::encode($nfp->StoneTransacao->numerocartao); ?> |
							</b>
							R$ <?php echo Yii::app()->format->formatNumber($nfp->StoneTransacao->valor); ?> |
							<?php if ($nfp->StoneTransacao->status != 1): ?>
								Cancelada
                            <?php else: ?>
                                Aprovada
							<?php endif; ?>
						</div>
						<div>
							<small class="muted">
								<?php echo CHtml::encode($nfp->StoneTransacao->criacao); ?> |
								<?php echo CHtml::encode($nfp->StoneTransacao->autorizacao); ?> |
								<?php echo CHtml::encode($nfp->StoneTransacao->stonetransactionid); ?>
							</small>
						</div>
					</div>
					<?php
					foreach ($nfp->StoneTransacao->StoneTransacaoParcelas as $stp) {
						?>
						<div class="row-fluid">
							<div>
									Parcela <?php echo Yii::app()->format->formatNumber($stp->numero, 0); ?> |
									R$ <?php echo Yii::app()->format->formatNumber($stp->valor); ?>
									<small class="muted">(<?php echo Yii::app()->format->formatNumber($stp->valorliquido); ?>) </small> |
									<?php echo $stp->vencimento ?>
							</div>
						</div>
						<?php
					}
				}
				?>
				<!-- PagarMe -->
				<?php
				if (!empty($nfp->codpagarmepedido))
				{
					?>
					<div class="row-fluid">
						<div>
							<b>
                <?php if ($nfp->PagarMePedido->tipo == 1): ?>
                    Débito
                <?php elseif ($nfp->PagarMePedido->tipo == 2): ?>
                    Crédito
                <?php else: ?>
                    Tipo <?php echo CHtml::encode($nfp->PagarMePedido->tipo); ?>
                <?php endif; ?>
								<?php if ($nfp->PagarMePedido->parcelas > 1): ?>
									<?php echo CHtml::encode($nfp->PagarMePedido->parcelas); ?> parcelas
								<?php endif; ?>
							</b>
						</div>
						<div>
							<small class="muted">
								<?php if ($nfp->PagarMePedido->valorpago != $nfp->valorpagamento): ?>
									Original R$ <?php echo Yii::app()->format->formatNumber($nfp->PagarMePedido->valorpago); ?>
								<?php endif; ?>
								<?php if ($nfp->PagarMePedido->valorcancelado > 0): ?>
									| Cancelado R$ <?php echo Yii::app()->format->formatNumber($nfp->PagarMePedido->valorcancelado); ?>
								<?php endif; ?>
								<?php if ($nfp->PagarMePedido->valorpago != $nfp->PagarMePedido->valorpagoliquido): ?>
									| Líquido R$ <?php echo Yii::app()->format->formatNumber($nfp->PagarMePedido->valorpagoliquido); ?>
								<?php endif; ?>
							</small>
						</div>
						<div>
							<small class="muted">
								<?php echo CHtml::encode($pagarMePedidoStatus[$nfp->PagarMePedido->status]); ?> |
								<?php echo CHtml::encode($nfp->PagarMePedido->idpedido); ?> |
								<?php echo CHtml::encode($nfp->PagarMePedido->criacao); ?>
							</small>
						</div>
					</div>
					<?php
					foreach ($nfp->PagarMePedido->PagarMePagamentos as $pag) {
						?>
						<div>
							<b>
								<?php if (!empty($pag->valorpagamento)): ?>
									<span class="text-success">
										<?php echo Yii::app()->format->formatNumber($pag->valorpagamento, 2); ?> Pago
									</span>
								<?php endif; ?>
								<?php if (!empty($pag->valorcancelamento)): ?>
									<span class="text-error">
										<?php echo Yii::app()->format->formatNumber($pag->valorcancelamento, 2); ?> Cancelado
									</span>
								<?php endif; ?>
								<?php if (!empty($pag->codpagarmebandeira)): ?>
									| <?php echo CHtml::encode($pag->PagarMeBandeira->bandeira); ?>
								<?php endif; ?>
								<?php if (!empty($pag->nome)): ?>
									| <?php echo CHtml::encode($pag->nome); ?>
								<?php endif; ?>
							</b>
						</div>
						<div class="muted">
							<small>
								StoneId <?php echo $pag->nsu ?> |
								Autorização <?php echo $pag->autorizacao ?> |
								<?php echo $pag->transacao ?>
								<br>
								<?php echo $pag->identificador ?> |
								<?php if (!empty($pag->codpagarmepos)): ?>
									Maquineta <?php echo CHtml::encode($pag->PagarMePos->apelido); ?>
									<?php echo CHtml::encode($pag->PagarMePos->serial); ?>
								<?php endif; ?>
							</small>
						</div>
						<?php
					}
				}
				?>

			</div>
		</span>
	</div>
	<?
}


?>
