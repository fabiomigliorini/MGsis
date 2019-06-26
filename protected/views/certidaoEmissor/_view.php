<div class="registro row-fluid">
	<small class="span2 muted"><?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codcertidaoemissor)),array('view','id'=>$data->codcertidaoemissor)); ?></small>
	<small class="span2 muted"><?php echo CHtml::link(CHtml::encode($data->certidaoemissor),array('view','id'=>$data->codcertidaoemissor)); ?></small>
	<small class="span2 muted"><?php echo CHtml::encode($data->inativo); ?></small>
</div>
