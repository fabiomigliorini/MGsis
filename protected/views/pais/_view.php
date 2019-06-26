<div class="registro row-fluid">
	<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codpais)); ?></small>
	
		<b class="span2"><?php echo CHtml::link(CHtml::encode($data->pais),array('view','id'=>$data->codpais)); ?></b>

		<small class="span1"><?php echo CHtml::encode($data->sigla); ?></small>

</div>