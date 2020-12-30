<?php
foreach ($model->PixCobs as $cob)
{
	?>
	<div class="registro">
		<span class="row-fluid">
			<span class="span7">
				<?php echo CHtml::encode($cob->codpixcob) ?>
				<?php echo CHtml::encode($cob->PixCobStatus->pixcobstatus) ?>
			</span>
			<span class="span3 text-right">
				<?php echo Yii::app()->format->formatNumber($cob->valororiginal); ?>
			</span>
			<span class="span2 text-right">
				<?php if ($cob->PixCobStatus->pixcobstatus == 'NOVA'): ?>
					<div class="pull-right">
						<button class="btn" type="button" onclick="transmitirPixCob(<?php echo $cob->codpixcob ?>)">
							<i class="icon-upload"></i>
						</button>
					</div>
				<?php endif; ?>
				<?php if ($cob->PixCobStatus->pixcobstatus == 'ATIVA'): ?>
					<div class="pull-right">
						<button class="btn" type="button" onclick="mostrarQrCodePixCob(<?php echo $cob->codpixcob ?>)">
							<i class="icon-qrcode"></i>
						</button>
					</div>
				<?php endif; ?>
			</span>
		</span>
	</div>
	<?
}
?>
