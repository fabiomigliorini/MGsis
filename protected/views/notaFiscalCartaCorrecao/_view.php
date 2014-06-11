<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnotafiscalcartacorrecao')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnotafiscalcartacorrecao)),array('view','id'=>$data->codnotafiscalcartacorrecao)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnotafiscal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->lote); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->data); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->sequencia); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->texto); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->protocolo); ?></small>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->protocolodata); ?></small>

		*/ ?>
</div>