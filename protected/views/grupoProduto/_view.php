<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codgrupoproduto)); ?>
	</small>
	
		<b
			class="span11"><?php echo CHtml::link(CHtml::encode($data->grupoproduto),array('view','id'=>$data->codgrupoproduto)); ?>
		</b>

</div>