<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnfeterceiroduplicata')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnfeterceiroduplicata)),array('view','id'=>$data->codnfeterceiroduplicata)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnfeterceiro); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codtitulo); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->ndup); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->dvenc); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->vdup); ?></small>

</div>