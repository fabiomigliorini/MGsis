<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codregistrospc)),array('registroSpc/view','id'=>$data->codregistrospc)); ?>
	</small>

		<b class="span1"><?php echo CHtml::encode($data->inclusao); ?></b>

		<small class="span1"><?php echo CHtml::encode($data->baixa); ?></small>

		<small class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valor)); ?></small>

</div>