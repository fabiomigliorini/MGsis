<div class="registro row-fluid">
	<small class="span1 muted">
            <?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codempresa)); ?>
	</small>
	<b class="span1 <?php echo ($data->modoemissaonfce == Empresa::MODOEMISSAONFCE_OFFLINE)?'alert-error':'alert-success'; ?>">
		<center><?php echo CHtml::encode($arrModoEmissaoNFCe[$data->modoemissaonfce]); ?></center>
	</b>
	<b class="span10">
		<?php echo CHtml::link(CHtml::encode($data->empresa),array('view','id'=>$data->codempresa)); ?>
	</b>
</div>