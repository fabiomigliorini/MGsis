<div class="registro row-fluid">
	<b class="span2">
		<?php echo CHtml::encode($data->getAttributeLabel('codfilial')); ?>:
		<?php echo CHtml::link(CHtml::encode(Yii::app()->format->formataCodigo($data->codfilial)),array('view','id'=>$data->codfilial)); ?>
	</b>
	
		<small class="span2 muted"><?php echo CHtml::encode($data->codempresa); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->codpessoa); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->filial); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->emitenfe); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorcaminho); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorcaminhorede); ?></small>

		<?php /*
		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorbloqueado); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorcodusuario); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->empresadominio); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorip); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->acbrnfemonitorporta); ?></small>

		<small class="span2 muted"><?php echo CHtml::encode($data->odbcnumeronotafiscal); ?></small>

		*/ ?>
</div>