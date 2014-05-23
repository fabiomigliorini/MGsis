<div class="registro row-fluid">
	<small class="span1 muted">
		<?php echo CHtml::encode(Yii::app()->format->formataCodigo($data->codunidademedida)); ?>
	</small>
	
		<b class="span2">
			<?php echo CHtml::link(CHtml::encode($data->unidademedida),array('view','id'=>$data->codunidademedida)); ?>
		</b>

		<small class="span9"><?php echo CHtml::encode($data->sigla); ?></small>

</div>