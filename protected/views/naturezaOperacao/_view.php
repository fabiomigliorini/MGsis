<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codnaturezaoperacao)); ?>
	</small>
	
	<b class="span2"><?php echo CHtml::link(CHtml::encode($data->naturezaoperacao),array('view','id'=>$data->codnaturezaoperacao)); ?> </b>

		<small class="span1 muted"><?php echo CHtml::encode($data->codoperacao); ?></small>

		<small class="span1 muted"><?php echo CHtml::encode($data->emitida); ?></small>

		<small class="span7 muted"><?php echo CHtml::encode($data->observacoesnf); ?></small>

</div>