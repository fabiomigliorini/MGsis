<div class="registro">
	<div class="row-fluid">
		<small class="span1 muted"><?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codcidade)); ?></small>
		
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode($data->cidade),array('cidade/view','id'=>$data->codcidade)); ?>
		</b>
		<small class="span1"><?php echo CHtml::encode($data->Estado->sigla); ?></small>
		
		<small class="span1"><?php echo CHtml::encode($data->sigla); ?></small>
		
		<small class="span1"><?php echo CHtml::encode($data->codigooficial); ?></small>
	</div>
</div>