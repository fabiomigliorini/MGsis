<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codmarca')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codmarca)),array('view','id'=>$data->codmarca)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->marca); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->site); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->descricaosite); ?></small>

</div>