<?php
$pagarMePedidoTipo = [
	1 => 'Débito',
	2 => 'Crédito',
	3 => 'Voucher',
];

$pagarMePedidoStatus = [
	1 => 'Pendente',
	2 => 'Pago',
	3 => 'Cancelado',
	4 => 'Falha',
];

foreach ($model->PagarMePedidos as $pmp)
{
	?>
	<div class="registro">
		<div class="row-fluid">
			<div class="pull-right">
				<button class="btn" type="button" onclick="consultarPagarMePedido(<?php echo $pmp->codpagarmepedido ?>)">
					<i class="icon-refresh"></i>
				</button>
				<button class="btn" type="button" onclick="cancelarPagarMePedido(<?php echo $pmp->codpagarmepedido ?>)">
					<i class="icon-trash"></i>
				</button>
			</div>
			<div>
				<b>
					R$ <?php echo Yii::app()->format->formatNumber($pmp->valor); ?>
				</b>
				<!-- <?php echo CHtml::encode($pmp->status); ?> -->
				<?php if (!empty($pmp->codpagarmepos)): ?>
					| Maquineta
					<?php echo CHtml::encode($pmp->PagarMePos->apelido); ?>
					<?php echo CHtml::encode($pmp->PagarMePos->serial); ?>
				<?php endif; ?>
				|
				<!-- <abbr title="<?php echo CHtml::encode($pmp->idpedido); ?>"> -->
					<?php echo CHtml::encode($pmp->idpedido); ?>
				<!-- </abbr> -->
			</div>
			<div>
				<?php echo CHtml::encode($pagarMePedidoTipo[$pmp->tipo]); ?>
				<?php if ($pmp->parcelas > 1): ?>
					<?php echo CHtml::encode($pmp->parcelas); ?> Parcelas
				<?php endif; ?>
				|
				<?php echo CHtml::encode($pagarMePedidoStatus[$pmp->status]); ?>
			</div>
		</div>

	</div>
	<?
}
?>
