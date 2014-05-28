<div class="registro row-fluid">
	<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codbanco)); ?></small>
	
		<b class="span2"><?php echo CHtml::link(CHtml::encode($data->banco),array('view','id'=>$data->codbanco)); ?> </b>

		<small class="span1 muted"><?php echo CHtml::encode($data->sigla); ?></small>

		<small class="span8 muted"><?php echo CHtml::encode($data->numerobanco); ?></small>

</div>