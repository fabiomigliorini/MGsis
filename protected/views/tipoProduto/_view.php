<div class="registro row-fluid">
	<b class="span1">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codtipoproduto)); ?>
	</b>
	
		<b
			class="span11"><?php echo CHtml::link(CHtml::encode($data->tipoproduto),array('view','id'=>$data->codtipoproduto)); ?>
		</b>

</div>