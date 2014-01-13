<div class="registro row-fluid">
	<b class="span4">
		<?php echo CHtml::link(CHtml::encode($data->tabela),array('view','id'=>$data->tabela)); ?>
	</b>
	<small class="span2 muted text-right">
		<?php echo CHtml::encode($data->codproximo); ?>
	</small>
</div>