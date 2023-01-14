<div class="row-fluid">
	<?php
    $total = 0;
    $ultima = 0;
    foreach ($model->NfeTerceiroDuplicatas as $dup) {
        $total += $dup->vdup;
        $ultima = $dup->vdup; ?>
		<small class="span1 text-center">
			<?php echo CHtml::encode($dup->ndup); ?><br>
			<b><?php echo CHtml::encode($dup->dvenc); ?></b><br>
			<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($dup->vdup)); ?></b>
		</small>
		<?php
    }

    if ($total != $ultima) {
        ?>
		<small class="span1 text-center">
			<b>Total <br> Duplicatas </b><br>
			<b><?php echo CHtml::encode(Yii::app()->format->formatNumber($total)); ?></b>
		</small>
		<?php
    }
    ?>
    <?php if (abs($total - $model->valortotal) >= 0.01): ?>
		<small class="span1 text-center alert-error">
			<b>
                Diferente <br> da Nota: <br>
                <?php echo CHtml::encode(Yii::app()->format->formatNumber($total)); ?>
            </b>
		</small>
    <?php endif; ?>
</div>
