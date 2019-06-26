<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codnegocioformapagamento')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codnegocioformapagamento)),array('view','id'=>$data->codnegocioformapagamento)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codnegocio); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codformapagamento); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->valorpagamento); ?></small>

</div>