<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codregistrospc)); ?>
	</small>
	<b class="span1">
		<?php echo CHtml::link(CHtml::encode($data->inclusao),array('registroSpc/view','id'=>$data->codregistrospc)); ?>
	</b>
	<small class="span1"><?php echo CHtml::encode($data->baixa); ?></small>
	<small class="span1 text-right"><?php echo CHtml::encode(Yii::app()->format->formatNumber($data->valor)); ?></small>
	<small class="span8 muted"><?php echo nl2br(CHtml::encode($data->observacoes)); ?></small>
</div>