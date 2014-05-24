<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codcontacontabil)); ?>
	</small>
	
		<b class="span2"><?php echo CHtml::link(CHtml::encode($data->contacontabil),array('view','id'=>$data->codcontacontabil)); ?></b>

		<small class="span1"><?php echo CHtml::encode($data->numero); ?></small>

		<b class="span7 muted"><?php echo ($data->inativo)?"Inativo":""; ?></b>

</div>