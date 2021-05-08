<?php
$stonePreTransacaoTipo = [
	1 => 'Débito',
	2 => 'Crédito',
	3 => 'Voucher',
];
foreach ($model->StonePreTransacaos as $spt)
{
	?>
	<div class="registro">
		<div class="row-fluid">
			<div class="pull-right">
				<button class="btn" type="button" onclick="consultarStonePreTransacao(<?php echo $spt->codstonepretransacao ?>)">
					<i class="icon-refresh"></i>
				</button>
			</div>
			<div>
				<b>
					R$ <?php echo Yii::app()->format->formatNumber($spt->valor); ?>
					<?php echo CHtml::encode($spt->status); ?>
				</b>
				<abbr title="<?php echo CHtml::encode($spt->pretransactionid); ?>">
					<?php echo CHtml::encode($spt->token); ?>
				</abbr>
			</div>
			<div>
				<?php echo CHtml::encode($stonePreTransacaoTipo[$spt->tipo]); ?>
				<?php if ($spt->parcelas > 1): ?>
				<?php echo CHtml::encode($spt->parcelas); ?> Parcelas
				<?php endif; ?>
				<?php if ($spt->processada): ?>
					Processada
				<?php else: ?>
					Pendente
				<?php endif; ?>
				<?php echo CHtml::encode($spt->processada); ?>
			</div>
			<div>
				<?php if (!empty($spt->cpf)): ?>
					<?php echo Yii::app()->format->formataCnpjCpf($spt->cpf); ?>
				<?php endif ?>
				<?php if (!empty($spt->cnpj)): ?>
					<?php echo Yii::app()->format->formataCnpjCpf($spt->cnpj); ?>
				<?php endif ?>
			</div>
		</div>

	</div>
	<?
}
?>
