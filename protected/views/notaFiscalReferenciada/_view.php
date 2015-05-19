<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnotafiscalreferenciada')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscalreferenciada)),array('view','id'=>$data->codnotafiscalreferenciada)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->nfechave); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codnotafiscal); ?></small>

</div>