<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codnaturezaoperacao)); ?>
	</small>
	
	<b class="span2"><?php echo CHtml::link(CHtml::encode($data->naturezaoperacao),array('view','id'=>$data->codnaturezaoperacao)); ?> </b>

		<small class="span1 muted"><?php echo CHtml::encode($data->Operacao->operacao); ?></small>

		<small class="span2 muted"><?php echo ($data->emitida)?"Nossa Emissão":""; ?></small>

		
		<small class="span6 muted"><?php echo nl2br(CHtml::encode($data->observacoesnf)); ?></small>

</div>