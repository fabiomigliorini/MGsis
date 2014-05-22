<div class="registro">
	<div class="row-fluid">
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode($data->cidade),array('view','id'=>$data->codcidade)); ?>
		</b>
		<small class="span1 muted">
			<?php echo CHtml::encode($data->Estado->sigla); ?>
		</small>
		<small class="span1 muted">
			<?php echo CHtml::encode($data->sigla); ?>
		</small>
		<small class="span1">
			<?php echo CHtml::encode($data->codigooficial); ?>
		</small>
	</div>
</div>