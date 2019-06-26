<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnotafiscalduplicatas')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscalduplicatas)),array('view','id'=>$data->codnotafiscalduplicatas)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnotafiscal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->fatura); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vencimento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valor); ?></small>

</div>