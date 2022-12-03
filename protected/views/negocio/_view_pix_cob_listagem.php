<?php
$cobs = $model->PixCobs;
$pixStatusCss = [
	1 => 'warning',   // 1	NOVA
	2 => 'success',   // 2	CONCLUIDA
	3 => 'warning',   // 3	ATIVA
	4 => 'error',     // 4	EXPIRADO
];
?>

<?php if (sizeof($cobs) > 0): ?>
	<table class="table table-condensed table-hover table-bordered" style="margin-bottom: 0px">
		<thead>
			<tr>
				<th>
					<div class="pull-right">
						Valor
					</div>
				</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cobs as $cob): ?>
				<tr class='<?php echo $pixStatusCss[$cob->codpixcobstatus] ?>'>
					<td rowspan="2">
						<div class="pull-right">
							<?php echo Yii::app()->format->formatNumber($cob->valororiginal); ?>
						</div>
					</td>
					<td>
						<?php echo CHtml::encode($cob->PixCobStatus->pixcobstatus); ?>
					</td>
					<td>
						<div class="pull-right">
							<button class="btn" type="button" onclick="buscarQrCodePixCob(<?php echo $cob->codpixcob ?>)">
								<i class="icon-qrcode"></i>
							</button>
						</div>
					</td>
				</tr>
				<tr class='<?php echo $pixStatusCss[$cob->codpixcobstatus] ?>'>
					<td colspan='2'>
						<small class="muted">
							<abbr title="<?php echo CHtml::encode($cob->location); ?>">
								<?php echo CHtml::encode($cob->txid); ?>
							</abbr>
							<?php if (!empty($cob->nome)): ?>
								<?php echo CHtml::encode($cob->nome); ?>
							<?php endif ?>
							<?php if (!empty($cob->cpf)): ?>
								<?php echo Yii::app()->format->formataCnpjCpf($cob->cpf); ?>
							<?php endif ?>
							<?php if (!empty($cob->cnpj)): ?>
								<?php echo Yii::app()->format->formataCnpjCpf($cob->cnpj); ?>
							<?php endif ?>
						</small>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
