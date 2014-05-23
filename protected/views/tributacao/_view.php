<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codtributacao)); ?>
	</small>
	
	<b class="span2">
		<?php echo CHtml::link(CHtml::encode($data->tributacao),array('view','id'=>$data->codtributacao)); ?>

	</b>

		<small class="span2 muted"><?php echo CHtml::encode($data->aliquotaicmsecf); ?></small>

</div>