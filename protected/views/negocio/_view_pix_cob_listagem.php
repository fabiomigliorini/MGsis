<?php
foreach ($model->PixCobs as $cob)
{
	?>
	<div class="registro">
		<div class="row-fluid">
			<div class="pull-right">
				<button class="btn" type="button" onclick="buscarQrCodePixCob(<?php echo $cob->codpixcob ?>)">
					<i class="icon-qrcode"></i>
				</button>
			</div>
			<div>
				<b>
					Valor Cobrança: <?php echo Yii::app()->format->formatNumber($cob->valororiginal); ?>
					<?php echo CHtml::encode($cob->PixCobStatus->pixcobstatus); ?>
				</b>
			</div>
			<div>
				<abbr title="<?php echo CHtml::encode($cob->location); ?>">
					<?php echo CHtml::encode($cob->txid); ?>
				</abbr>
			</div>
			<div>
				<?php echo CHtml::encode($cob->nome); ?>
			</div>
			<div>
				<?php if (!empty($cob->cpf)): ?>
					<?php echo Yii::app()->format->formataCnpjCpf($cob->cpf); ?>
				<?php endif ?>
				<?php if (!empty($cob->cnpj)): ?>
					<?php echo Yii::app()->format->formataCnpjCpf($cob->cnpj); ?>
				<?php endif ?>
			</div>
		</div>

	</div>
	<?
}
?>
