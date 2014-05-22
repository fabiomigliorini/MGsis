<div class="registro row-fluid">
	<b class="span1">
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codcontacontabil)),array('view','id'=>$data->codcontacontabil)); ?>
	</b>
	
		<b class="span2"><?php echo CHtml::encode($data->contacontabil); ?></b>

		<small class="span1"><?php echo CHtml::encode($data->numero); ?></small>

		<small class="span7"><?php echo CHtml::encode($data->inativo); ?></small>

</div>