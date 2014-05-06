<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnegocioprodutobarra')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnegocioprodutobarra)),array('view','id'=>$data->codnegocioprodutobarra)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnegocio); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->quantidade); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valorunitario); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valortotal); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codprodutobarra); ?></small>

</div>