<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codtipoproduto)); ?>
	</small>
	
		<b
			class="span11"><?php echo CHtml::link(CHtml::encode($data->tipoproduto),array('view','id'=>$data->codtipoproduto)); ?>
		</b>

</div>