<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codgrupocliente)); ?>
	</small>
	
	<b class="span3">
		<?php echo CHtml::link(CHtml::encode($data->grupocliente), array('view', 'id'=>$data->codgrupocliente)); ?>
	</b>

</div>