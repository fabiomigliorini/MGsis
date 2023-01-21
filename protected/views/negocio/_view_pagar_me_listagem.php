<?php
$pagarMePedidoTipo = [
	1 => 'Débito',
	2 => 'Crédito',
	3 => 'Voucher',
	4 => 'Tipo 4',
];

$pagarMePedidoStatus = [
	1 => 'Pendente',
	2 => 'Pago',
	3 => 'Cancelado',
	4 => 'Falha',
];

$pagarMePedidoStatusCss = [
	1 => 'warning',
	2 => 'success',
	3 => 'error',
	4 => 'error',
];

$pmps = $model->PagarMePedidos;
?>
<?php if (sizeof($pmps) > 0): ?>
	<table class="table table-condensed table-hover table-bordered" style="margin-bottom: 0px">
		<thead>
			<tr>
				<th>Valor</th>
				<th>Tipo</th>
				<th>Maquineta</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($pmps as $pmp): ?>
				<tr class='<?php echo $pagarMePedidoStatusCss[$pmp->status] ?>'>
					<td rowspan="2">
						<abbr title='#<?php echo CHtml::encode($pmp->codpagarmepedido); ?> ID <?php echo CHtml::encode($pmp->idpedido); ?>'>
							<?php echo Yii::app()->format->formatNumber($pmp->valor); ?>
						</abbr>
					</td>
					<td>
						<?php echo CHtml::encode($pagarMePedidoTipo[$pmp->tipo]); ?>
						<?php if ($pmp->parcelas > 1): ?>
							<br>
							<?php echo CHtml::encode($pmp->parcelas); ?> Parcelas de R$
                            <?php echo Yii::app()->format->formatNumber($pmp->valorparcela); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if (!empty($pmp->codpagarmepos)): ?>
							<abbr title='<?php echo CHtml::encode($pmp->PagarMePos->serial); ?>'>
								<?php echo CHtml::encode($pmp->PagarMePos->apelido); ?>
							</abbr>
						<?php endif; ?>
					</td>
					<td>
						<?php echo CHtml::encode($pagarMePedidoStatus[$pmp->status]); ?>
						<div class="pull-right">
							<button class="btn" type="button" onclick="consultarPagarMePedido(<?php echo $pmp->codpagarmepedido ?>)">
								<i class="icon-refresh"></i>
							</button>
							<button class="btn" type="button" onclick="cancelarPagarMePedido(<?php echo $pmp->codpagarmepedido ?>)">
								<i class="icon-trash"></i>
							</button>
						</div>
					</td>
				</tr>
				<tr class='<?php echo $pagarMePedidoStatusCss[$pmp->status] ?>'>
					<?php if (!empty($pmp->valorcancelado) || (($pmp->valorpagoliquido > 0 && $pmp->valorpagoliquido != $pmp->valor))): ?>
						<td class="text-right" colspan='3'>
							<?php if ($pmp->valorcancelado > 0): ?>
								R$ <?php echo Yii::app()->format->formatNumber($pmp->valorcancelado); ?> Cancelado |
							<?php endif; ?>
							<?php if ($pmp->valorpagoliquido > 0 && $pmp->valorpagoliquido != $pmp->valor): ?>
								R$ <?php echo Yii::app()->format->formatNumber($pmp->valorpagoliquido); ?> Líquido
							<?php endif; ?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
